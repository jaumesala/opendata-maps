
@include('admin.includes.page_head')

<div class="wrapper">
    @include('admin.components.header')

    @include('admin.components.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @yield('content', 'content')

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

@include('admin.components.footer')

{{-- @include('admin.components.control-sidebar') --}}

@include('admin.includes.page_tail')