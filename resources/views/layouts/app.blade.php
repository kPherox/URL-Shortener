<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,300,400,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/TopNav/top_nav.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white">
                <div class="container">
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#app-navbar" aria-controls="#app-navbar" aria-label="Toggle Navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="app-navbar">
                        <!-- Left Side Of Navbar -->
                        @laraveltopnav

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                            @else
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" id="navbarDropdownMenuLink"  aria-expanded="false">
                                    {{ auth()->user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <li class="dropdown-item"><a class="nav-link" href="{{ route('my-page') }}">My Page</a></li>
                                    <li class="dropdown-item"><a id="logout-button" class="nav-link" href="{{ route('logout') }}">Logout</a></li>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                    <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        document.getElementById('logout-button').addEventListener('click', function(e) {
                                            e.preventDefault();
                                            document.getElementById('logout-form').submit();
                                        });
                                    });
                                    </script>
                                </ul>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
