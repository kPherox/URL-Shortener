@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!

                    <ul>
                        @foreach ( $shortUrls as $shortUrl )
                            <li>
                                <div>{{ $shortUrl->long_url }}</div>
                                <div><a href="{{ env('APP_URL', 'http://localhost') . '/' . $shortUrl->short_url }}">{{ env('APP_URL', 'http://localhost/') . '/' . $shortUrl->short_url }}</a></div>
                                <div>{{ $shortUrl->url_name }}</div>
                                <div>{{ $shortUrl->created_at }}</div>
                                <div>{{ $shortUrl->updated_at }}</div>
                            </li>
                        @endforeach
                    </ul>

                    {{ $shortUrls->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
