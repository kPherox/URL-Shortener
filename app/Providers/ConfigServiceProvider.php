<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        config([
            'top_nav.menu' => [
                'about'  => url('/about'),
                'blog'   => url('/blog'),
                'news'   => url('/news'),
                'github' => env('APP_GITHUB_URL', 'https://github.com/kPherox/URL-Shortener'),
            ],
        ]);
    }
}
