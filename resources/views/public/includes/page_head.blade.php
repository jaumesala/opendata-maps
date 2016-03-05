<!DOCTYPE html>
<?php
    $locale = config('app.locale') //LaravelLocalization::getCurrentLocale();
?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="{{ $locale }}"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="{{ $locale }}"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="{{ $locale }}"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="{{ $locale }}"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        @if (App::environment() != 'production') {{ App::environment() }} | @endif {{ $customTitle or '' }}  {{ trans('includes/page_head.title_'.Route::currentRouteName()) }}
    </title>
    <meta name="description" content="{{ trans('includes/page_head.description_'.Route::currentRouteName()) }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <meta name="author" content="Jaume Sala">
    <link type="text/plain" rel="author" href="{{ url('humans.txt') }}" />

    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon-precomposed.png') }}">

    {{--
    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        @if ( $locale != $localeCode )
            <link rel="alternate" hreflang="{{ $localeCode }}" href="{{ $urlLocale[$localeCode] or LaravelLocalization::getLocalizedURL($localeCode) }}" />
        @endif
    @endforeach
    --}}
    <meta property="og:title" content="{{ trans('includes/page_head.title_'.Route::currentRouteName()) }}" />
    <meta property="og:description" content="{{ trans('includes/page_head.description_'.Route::currentRouteName()) }}" />
    <meta property="og:image" content="{{ asset('img/apple-touch-icon.png') }}" />
    <meta property="og:site_name" content="Schiedam"/>
    <meta property="og:url" content="{{ $urlLocale[$locale] or Request::url() }}"/>

    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->

    <!-- Mapbox styles -->
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.14.2/mapbox-gl.css' rel='stylesheet' />
    <!-- <link href='https://api.mapbox.com/mapbox.js/v2.3.0/mapbox.css' rel='stylesheet' /> -->

    @if (App::environment() != 'production')
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
    @endif

    <script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>

</head>
<body   id="@yield('customBodyId', ''){{ $routeName or Route::currentRouteName() }}"
        class="@yield('customBodyClass', '') {{ $routeMethod or '' }}"
        data-controller="@yield('customBodyController', ''){{ $routeName or Route::currentRouteName() }}"
        data-action="@yield('customBodyMethod', '') {{ $routeMethod or '' }}">
    <!--[if lt IE 7]>
    <p class="browsehappy">{{ trans('includes/page_head.chrome_frame') }}</p>
    <![endif]-->