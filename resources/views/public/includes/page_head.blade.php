<!DOCTYPE html>
<?php
    $locale = config('app.locale')
?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="{{ $locale }}"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="{{ $locale }}"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="{{ $locale }}"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="{{ $locale }}"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @if (App::environment() != 'production') {{ App::environment() }} | @endif {{ $customTitle or setting_value('application', 'title') }}
    </title>
    <meta name="description" content="{{ $customDescription or 'Map by '.setting_value('application', 'title') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">

    <meta name="author" content="Jaume Sala">
    <link type="text/plain" rel="author" href="{{ url('humans.txt') }}" />

    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon-precomposed.png') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Mapbox styles -->
    <link href='{!! setting_value('mapbox', 'glStyle') !!}' rel='stylesheet' />

    @if (App::environment() != 'production')
        <link rel="stylesheet" href="{{ asset('css/public/app.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/public/app.min.css') }}">
    @endif

    <!-- Modernizr -->
    <script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>

</head>
<body   id="@yield('customBodyId', ''){{ $routeName or Route::currentRouteName() }}"
        class="@yield('customBodyClass', '') {{ $routeMethod or '' }}"
        data-controller="@yield('customBodyController', ''){{ $routeName or Route::currentRouteName() }}"
        data-action="@yield('customBodyMethod', ''){{ $routeMethod or '' }}">
    <!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->