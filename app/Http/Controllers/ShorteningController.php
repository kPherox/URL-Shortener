<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShorteningRequest;
use App\ShortUrl;

class ShorteningController extends Controller
{
    // URL Shortening controller

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Create a new short url instance after a valid registration.
     *
     * @param array $data
     *
     * @return \App\Http\Request\ShorteningRequest
     */
    public function create(ShorteningRequest $request)
    {
        $longUrl = $request->url;
        $shortUrl = auth()->check() ? $request->shorturl : null;
        $urlName = auth()->check() ? $request->urlname : null;

        if (auth()->check() && ShortUrl::longUrlExists($longUrl, auth()->id())) {
            $shortUrl = ShortUrl::getShortUrl($longUrl, auth()->id());

            return redirect($this->redirectTo)
                ->with('status', 'already')
                ->with('result', 'Already Shorting URL')
                ->with('shortUrl', $shortUrl);
        }

        if ($this->isSelfHost($longUrl)) {
            return redirect($this->redirectTo)
                ->with('status', 'warning')
                ->with('result', 'Cannot Shorting '.config('app.url'))
                ->with('shortUrl', $longUrl);
        }

        if ($shortUrl && auth()->check()) {
            $shortUrl = $shortUrl;
        } else {
            do {
                $randomStr = str_random(6);
                $shortUrlExists = ShortUrl::ofShortUrl($randomStr)->exists();
            } while ($shortUrlExists);
            $shortUrl = $randomStr;
        }

        $result = ShortUrl::create([
            'short_url'  => $shortUrl,
            'long_url'   => $longUrl,
            'url_name'   => $urlName,
            'registered' => auth()->check(),
            'user_id'    => auth()->id(),
        ]);

        return redirect($this->redirectTo)
            ->with('status', 'success')
            ->with('result', 'Success URL Shorten')
            ->with('shortUrl', $shortUrl);
    }

    private function isSelfHost($link)
    {
        return parse_url($link, PHP_URL_HOST) === parse_url(config('app.url'), PHP_URL_HOST);
    }
}
