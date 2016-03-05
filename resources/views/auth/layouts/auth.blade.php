@section('customBodyId', 'auth')
@section('customBodyController', 'auth')

@include('admin.includes.page_head')

@yield('content', 'content')

@include('admin.includes.page_tail')