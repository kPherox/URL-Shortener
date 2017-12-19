<?php

namespace App\Http\Controllers;

use App\ShortUrl;
use App\Http\Requests\ShortUrlRequest;

class ShortUrlController extends Controller
{
    // URL Shorteninn controller

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
     * @param  array  $data
     * @return \App\Http\Request\ShortUrlRequest
     */
    public function create(ShortUrlRequest $request)
    {
        $longUrl = $request->url;

        $shortUrls = new ShortUrl;
        if (auth()->check()) {
            $hasLongUrl = $shortUrls->longUrlExists($longUrl, auth()->id());
            if ($hasLongUrl) {
                $shortUrl = $shortUrls->getShortUrl($longUrl, auth()->id());
                return redirect($this->redirectTo)
                    ->with('status', 'already')
                    ->with('result', 'Already Shorting URL')
                    ->with('shortUrl', $shortUrl);
            }
        }

        if (is_null($request->shortUrl) || auth()->guest()) { 
            do {
                $randomStr = str_random(6);
                $shortUrlExists = ShortUrl::ofShortUrl($randomStr)->exists();
            } while ($shortUrlExists);
            $shortUrl = $randomStr;
        } else {
            $shortUrl = $request->shortUrl;
        }

        $urlName = is_null($request->urlName) || auth()->guest() ? null : $request->urlName;
        $result = ShortUrl::create([
            'short_url' => $shortUrl,
            'long_url' => $longUrl,
            'url_name' => $urlName,
            'registed' => auth()->check(),
            'user_id' => auth()->id(),
        ]);

        return redirect($this->redirectTo)
            ->with('status', 'success')
            ->with('result', 'Success URL Shorten')
            ->with('shortUrl', $shortUrl);
    }
}
