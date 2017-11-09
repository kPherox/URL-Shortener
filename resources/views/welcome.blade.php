@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="display-2 text-center mb-3">{{ config('app.name', 'Laravel') }}</h1>

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">URL Shortener</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('shortener') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }} row">
                            <label for="url" class="col-lg-4 col-form-label text-lg-right">URL</label>

                            <div class="col-lg-6">
                                <input id="url" type="url" class="form-control" name="url" value="{{ old('url') }}" required autofocus>

                                @if ($errors->has('url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="shortUrl" class="col-lg-4 col-form-label text-lg-right">Custom String</label>
                            
                            <div class="col-lg-6">
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

                        <div class="form-group row">
                            <label for="urlName" class="col-lg-4 col-form-label text-lg-right">URL Title</label>

                            <div class="col-lg-6">
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

                        <div class="form-group row">
                            <div class="col-lg-8 offset-lg-4">
                                <button type="submit" class="btn btn-primary">
                                    URL Shorting
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

