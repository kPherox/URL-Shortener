<?php

use Illuminate\Http\Request;
use App\ShortUrl;

function isSelfHost($link)
{
    $link = parse_url($link);
    $linkHost = $link['host'];
    $self = parse_url(config('app.url'));
    $selfHost = $self['host'];

    return $linkHost === $selfHost;
}

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/shortening', function (Request $request) {
    $userId = (int)$request->query('id');
    $longUrl = $request->query('longurl');

    if (isSelfHost($longUrl)) {
        return $longUrl;
    }

    $shortUrls = ShortUrl::ofLongUrlAndUserId($longUrl, $userId);
    if ($shortUrls->exists()) {
        /*return response()->json([
            'shortUrl' => $longUrl->first()->short_url,
        ]);*/
        return url($shortUrls->first()->short_url);
    }

    $shortUrl = $request->query('shorturl');
    if (is_null($shortUrl)) {
        do {
            $randomStr = str_random(6);
            $shortUrlExists = ShortUrl::ofShortUrl($randomStr)->exists();
        } while ($shortUrlExists);
        $shortUrl = $randomStr;
    } else {
        $shortUrl = $shortUrl;
    }

    $urlName = is_null($request->query('urlname')) ? null : $request->query('urlname');
    $result = ShortUrl::create([
        'short_url' => $shortUrl,
        'long_url' => $longUrl,
        'url_name' => $urlName,
        'registed' => 1,
        'user_id' => $userId,
    ]);

    return url($result->short_url);
});
