@extends('admin.layouts.admin')


@section('content')

@include('admin.components.form-confirmations')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Maps
        <small>Create a new map</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.map.index') }}">Maps</a></li>
        <li class="active">Create</li>
    </ol>
</section>

<!-- Main content -->
<section id="map-creator" class="content">

    <!-- Page Content -->
    @include('admin.components.form-alerts')

    <div class="row">

        <div class="col-sm-12 col-md-5 col-lg-4">

            <div id="controls-view" class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-info" data-toggle="tab">Info</a></li>
                    <li><a href="#tab-layers" data-toggle="tab">Design</a></li>
                </ul>
                <div class="tab-content">

                        <div class="tab-pane active" id="tab-info">
                            <!-- <form method="POST" action="{{ route('admin.map.store') }}" v-on:submit.prevent="saveData"> -->
                            <form method="POST" action="{{ route('admin.map.store') }}" >
                                {{ csrf_field() }}

                                <input type="hidden" id="id" name="id" value="" v-model="map.id">

                                @if($errors->has("name")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="The map's name" v-model="map.name" value="{{ old('name') }}">
                                    @if ($errors->has("name"))
                                        <p class="help-block">
                                            {{ $errors->first("name") }}
                                        </p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    {!! Form::select('status',
                                        [   'public' => 'Public',
                                            'private' => 'Private',
                                            'disabled' => 'Disabled' ],
                                        old('status', null),
                                        [   'id' => 'status',
                                            'class' => 'form-control select2',
                                            'data-options' => '{ "minimumResultsForSearch": -1 }',
                                            'v-model' => 'map.status',
                                            'v-select2' => 'map.status' ]
                                            ) !!}
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5" v-model="map.description"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="name">Tags</label>
                                    {!! Form::select('tags[]',
                                        $tags->lists('name','id'),
                                        old('tags', null),
                                        [   'id' => 'tags',
                                            'class' => 'form-control select2',
                                            'multiple' => 'multiple',
                                            // 'data-options' => '{ "tags": true, "tokenSeparators": [",", " "] }',
                                            'data-options' => '{ "tokenSeparators": [",", " "] }',
                                            // 'v-model' => 'map.tags',
                                            'v-select2' => 'map.tags' ]
                                            ) !!}
                                </div>
                                <button type="submit" class="btn bnt-default">save</button>
                            </form>

                        </div>
                        <!-- /.tab-pane -->

                    <div class="tab-pane" id="tab-layers">
                        layers
                    </div>
                    <!-- /.tab-pane -->

                </div>
                <!-- /.tab-content -->

            </div>
            <!-- /#controls-view -->
        </div>

        <div class="col-sm-12 col-md-7 col-lg-8">
            <div class="box box-solid box-map">
                <div class="box-body">
                    <div id="map-view" class="mapboxgl-map" style="height: 200px;">
                </div>
                <!-- /.box-body -->
            </div>
        </div>

    </div>

</section>
<!-- /.content -->

@stop