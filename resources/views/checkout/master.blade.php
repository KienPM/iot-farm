@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body" style="min-height: 82vh; font-size: 20px">
                    @yield('message')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
