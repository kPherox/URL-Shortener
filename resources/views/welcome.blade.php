@extends('layouts.app')

@section('content')
<div class="container">
    <div class="title m-b-md">
        <p>{{ config('app.name', 'Laravel') }}</p>
    </div>

    <div class="links">
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">URL Shortener</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('shortener') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                            <label for="url" class="col-md-4 control-label">URL</label>

                            <div class="col-md-6">
                                <input id="url" type="url" class="form-control" name="url" value="{{ old('url') }}" required autofocus>

                                @if ($errors->has('url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="shortUrl" class="col-md-4 control-label">Custom String</label>
                            
                            <div class="col-md-6">
                                <input id="shortUrl" type="text" class="form-control" name="shortUrl" value=""
                                @guest
                                    placeholder="Need login to use this feature" readonly
                                @endguest
                                >

                                @if ($errors->has('shortUrl'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('shortUrl') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="urlName" class="col-md-4 control-label">URL Name</label>
                            
                            <div class="col-md-6">
                                <input id="urlName" type="text" class="form-control" name="urlName" value=""
                                @guest
                                    placeholder="Need login to use this feature" readonly
                                @endguest
                                >

                                @if ($errors->has('urlName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('urlName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    URL Shorting
                                </button>
                            </div>
                        </div>
                    </form>

                    <script type="text/javascript">
                        var csrfToken = $('[name="csrf_token"]').attr('content');

                        setInterval(refreshToken, 3600000); // 1 hour 

                        function refreshToken(){
                            $.get('refresh-csrf').done(function(data){
                                csrfToken = data; // the new token
                            });
                        }

                        setInterval(refreshToken, 3600000); // 1 hour 
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

