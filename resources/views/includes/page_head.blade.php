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
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Jaume Sala">
    <link type="text/plain" rel="author" href="{{ url('humans.txt') }}" />

    <link rel="dns-prefetch" href="//ajax.googleapis.com" />
    <meta name="google-site-verification" content="" />

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
    <meta property="og:site_name" content="<SUKI-BASE>"/>
    <meta property="og:url" content="{{ $urlLocale[$locale] or Request::url() }}"/>


    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.14.1/mapbox-gl.css' rel='stylesheet' />

    @if (App::environment() != 'production')
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('css/main.min.css') }}">
    @endif

    <script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>

</head>
<body id="{{ $routeName or Route::currentRouteName() }}" class="{{ $routeMethod or 'index' }}" data-controller="{{ $routeName or Route::currentRouteName() }}" data-action="{{ $routeMethod or 'index' }}">
    <!--[if lt IE 7]>
    <p class="browsehappy">{{ trans('includes/page_head.chrome_frame') }}</p>
    <![endif]-->