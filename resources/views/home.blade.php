@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>

            <div class="card">
                <div class="card-header">Shortened URLs</div>

                <ul class="list-group list-group-striped">
                    @foreach ( $shortUrls as $shortUrl )
                        <li class="list-group-item border-0">
                            <dl class="row mb-0">
                                <dt class="col-lg-3 text-lg-right">URL Title</dt>
                                    <dd class="col-lg-9">{{ is_null($shortUrl->url_name) ? 'null' : $shortUrl->url_name }}</dd>
                                <dt class="col-lg-3 text-lg-right">Long URL</dt>
                                    <dd class="col-lg-9">{{ $shortUrl->long_url }}</dd>
                                <dt class="col-lg-3 text-lg-right">Short URL</dt>
                                    <dd class="col-lg-9"><a href="{{ url( $shortUrl->short_url ) }}">{{ url( $shortUrl->short_url ) }}</a></dd>
                                <dt class="col-lg-3 text-lg-right">Create Date</dt>
                                    <dd class="col-lg-9">{{ $shortUrl->created_at }}</dd>
                                <dt class="col-lg-3 text-lg-right">Last Update Date</dt>
                                    <dd class="col-lg-9">{{ $shortUrl->updated_at }}</dd>
                            </dl>
                        </li>
                    @endforeach
                </ul>

                <div class="card-footer">{{ $shortUrls->links() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
