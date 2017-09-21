@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body" style="min-height: 82vh">
                    @yield('message')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
