<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedirectController extends Controller
{
    // Redirect method
    function redirect($shortUrl) {
        $url = DB::table('short_urls')->where('short_url', $shortUrl)->first();
        if ($url) {
            return redirect($url->long_url);
        } else {
            return abort('404');
        }
    }
}
