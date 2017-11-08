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
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Shortened URLs</div>

                <div class="panel-body">
                    <div class="list-group list-group-striped">
                        @foreach ( $shortUrls as $shortUrl )
                            <dl class="list-group-item dl-horizontal">
                                <dt>URL Title</dt>
                                    <dd>{{ is_null($shortUrl->url_name) ? 'null' : $shortUrl->url_name }}</dd>
                                <dt>Long URL</dt>
                                    <dd>{{ $shortUrl->long_url }}</dd>
                                <dt>Short URL</dt>
                                    <dd><a href="{{ url( $shortUrl->short_url ) }}">{{ url( $shortUrl->short_url ) }}</a></dd>
                                <dt>Create Date</dt>
                                    <dd>{{ $shortUrl->created_at }}</dd>
                                <dt>Last Update Date</dt>
                                    <dd>{{ $shortUrl->updated_at }}</dd>
                            </dl>
                        @endforeach
                    </div>

                    {{ $shortUrls->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
