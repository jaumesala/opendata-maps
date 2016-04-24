@extends('tests.layouts.baseLayout')


@section('content')

<div id="body">
    <div class="container-fluid">
        <ul>
            <li><a href="{{ route('neighborhoods.index') }}">Neighborhoods</a></li>
        </ul>
    </div>
</div>

@stop