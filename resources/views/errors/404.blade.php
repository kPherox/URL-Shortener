@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-header">404 Not Found</div>

                <div class="card-body">
                    {{ $exception->getMessage() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

