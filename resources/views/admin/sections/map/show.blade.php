@extends('admin.layouts.admin')


@section('content')

@include('admin.components.share-modal')

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
                        @foreach($map->tags as $tag)
                            <span class="label label-default">{{ $tag->name }}</span>
                        @endforeach
                    </p>

                    <hr>

                    <strong><i class="fa fa-bars margin-r-5"></i> layers</strong>

                    <ul class="list-unstyled layers-list">
                        @foreach($map->layers as $layer)
                        <li>
                            {{ $layer->name }}

                            <span class="label label-default pull-right">{{ $layer->type }}</span>
                            {{--
                            @if($layer->visible)
                                <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-eye-slash"></i></a>
                                <a href="#" class="btn btn-default btn-xs pull-right hidden"><i class="fa fa-eye"></i></a>
                            @else
                                <a href="#" class="btn btn-default btn-xs pull-right hidden"><i class="fa fa-eye-slash"></i></a>
                                <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-eye"></i></a>
                            @endif
                            --}}
                        </li>
                        @endforeach
                    </ul>

                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <div class="btn-group">
                        <button class="btn btn-default" data-toggle="modal" data-target="#shareModal"><i class="fa fa-fw fa-share-alt"></i> Share</button>
                        @permission('edit-map')
                        <a href="{{ route('admin.map.edit', $map->id) }}" class="btn btn-default"><i class="fa fa-fw fa-pencil"></i> Edit</a>
                        @endpermission
                    </div>
                </div>
            </div> <!-- /.box-widget -->

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

@push('preAppScripts')
    <script>
        var map = {!! json_encode($map) !!}
    </script>
@endpush