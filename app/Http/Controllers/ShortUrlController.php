<?php

namespace App\Http\Controllers;

use Auth;
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

        if (Auth::check()) {
            $shortUrls = ShortUrl::where('long_url', $longUrl)->where('user_id', Auth::id())->first();
            if (!is_null($shortUrls)) {
                return redirect($this->redirectTo)
                    ->with('status', 'already')
                    ->with('result', 'Already Shorting URL')
                    ->with('shortUrl', $shortUrls->short_url);
            }
        }

        $shortUrl = is_null($request->shortUrl) ? str_random(6) : $request->shortUrl;
        $urlName = $request->urlName;
        $result = ShortUrl::create([
            'short_url' => $shortUrl,
            'long_url' => $longUrl,
            'url_name' => $urlName,
            'registed' => Auth::check(),
            'user_id' => Auth::id(),
        ]);

        return redirect($this->redirectTo)
            ->with('status', 'success')
            ->with('result', 'Success URL Shorten')
            ->with('shortUrl', $shortUrl);
    }
}
