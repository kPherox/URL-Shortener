<?php

namespace App\Http\Controllers;

use App\ShortUrl;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        $shortUrls = ShortUrl::where('user_id', $user->id)->paginate(15);

        return view('home')->with('shortUrls', $shortUrls);
    }
}
