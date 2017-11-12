<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortUrl;

class RedirectController extends Controller
{
    // Redirect method
    function redirect($shortUrl) {
        $url = ShortUrl::ofShortUrl($shortUrl)->first();

        abort_if(is_null($url) , '404', 'Sorry, the page you are looking for could not be found.');

        return redirect($url->long_url);
    }
}
