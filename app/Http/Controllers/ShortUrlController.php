<?php

namespace App\Http\Controllers;

use App\ShortUrl;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequest;
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
        $user = \Auth::user();
        $shortUrl = empty($request->shortUrl) ? str_random(6) : $request->shortUrl;
        $longUrl = $request->url;
        $urlName = $request->urlName;

        $result = ShortUrl::create([
            'short_url' => $shortUrl,
            'long_url' => $longUrl,
            'url_name' => $urlName,
            'registed' => empty($user) ? false : true,
            'user_id' => empty($user) ? null : $user->id,
        ]);
        return redirect($this->redirectTo);
    }
}
