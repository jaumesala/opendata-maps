@extends('admin.layouts.admin')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Your Page Content Here -->
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $maps }}</h3>

                    <p>Maps</p>
                </div>
                <div class="icon">
                    <i class="fa fa-map"></i>
                </div>
                <a href="{{ route('admin.map.index') }}" class="small-box-footer">
                    Veiw maps <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
            <a href="{{ route('admin.map.create') }}" class="btn btn-danger btn-block">Create a new map</a>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $sources }}</h3>

                    <p>Sources</p>
                </div>
                <div class="icon">
                    <i class="fa fa-database"></i>
                </div>
                <a href="{{ route('admin.source.index') }}" class="small-box-footer">
                    Veiw sources <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
            <a href="{{ route('admin.source.create') }}" class="btn btn-success btn-block">Add a new source</a>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $users }}</h3>

                    <p>Users</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user"></i>
                </div>
                <a href="{{ route('admin.user.index') }}" class="small-box-footer">
                    Veiw users <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
            <a href="{{ route('admin.user.create') }}" class="btn btn-warning btn-block">Add a new user</a>
        </div>
    </div>



</section>
<!-- /.content -->

@stop