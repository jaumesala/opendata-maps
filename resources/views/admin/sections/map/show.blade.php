@extends('admin.layouts.admin')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Maps
        <small>view the map</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.map.index') }}">Maps</a></li>
        <li class="active">view</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Page Content -->
    <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-3">

            <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
                <h3 class="widget-user-username">{{ $map->name }}</h3>
            </div>
            <div class="box-body">
                <strong><i class="fa fa-info-circle margin-r-5"></i> Description</strong>
                <p class="text-muted">
                    {{ $map->description }}
                </p>

                <hr>

                <strong><i class="fa fa-user margin-r-5"></i> Creator</strong>
                <?php
                    $createdAt  = $map->created_at;
                    $date       = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt);
                ?>
                <p class="text-muted">By {{ $map->user->name }}, {{ $date->diffForHumans() }}</p>

                <hr>

                <strong><i class="fa fa-tags margin-r-5"></i> Tags</strong>

                <p>
                    <span class="label label-default">Schiedam</span>
                    <span class="label label-default">Neighbourhoods</span>
                    <span class="label label-default">Districts</span>
                    <span class="label label-default">Energy</span>
                    <span class="label label-default">2015</span>
                    <span class="label label-default">Lighting</span>
                    <span class="label label-default">Smart Cities</span>
                </p>

            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                    <li><a href="#">Projects</a></li>
                    <li><a href="#">Tasks</a></li>
                </ul>
            </div>
          </div>




        </div>
        <div class="col-sm-12 col-md-8 col-lg-9">
            <div class="box box-solid box-map">
                <!-- <div class="box-header with-border">
                    <h3 class="box-title">Progress Bars Different Sizes</h3>
                </div> -->
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="map-view">

                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>


</section>
<!-- /.content -->

@stop