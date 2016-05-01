@extends('public.layouts.notFound')

@section('content')

<div id="map-view">

    <div class="not-found">
        <p class="lead">Welcome</p>
        <p>To access the application, please login through the <a href="{{ route('admin.dashboard.index') }}">admin</a> url</p>
    </div>


</div>

@stop