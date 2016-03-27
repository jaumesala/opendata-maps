@extends('admin.layouts.admin')


@section('content')

@include('admin.components.form-confirmations')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Maps
        <small>Edit the map</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.map.index') }}">Maps</a></li>
        <li class="active">Edit</li>
    </ol>
</section>

<!-- Main content -->
<section id="editor" class="content">

    <!-- Page Content -->
    @include('admin.components.form-alerts')

    <div class="row">

        <div class="col-sm-12 col-md-5 col-lg-4">

            <form method="POST" action="{{ route('admin.map.store') }}" >
                {{ csrf_field() }}

                <div id="controls-view" class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-info" data-toggle="tab">Info</a></li>
                        <li><a href="#tab-design" data-toggle="tab">Design</a></li>
                        <li><a href="#tab-layers" data-toggle="tab">Layers</a></li>
                    </ul>
                    <div class="tab-content">

                        <div class="tab-pane active" id="tab-info">

                            <form-input
                                type="hidden"
                                name="name"
                                id="name"
                                :model.sync="map.id"
                            ></form-input>

                            <form-input
                                type="text"
                                label="Name"
                                name="name"
                                id="name"
                                placeholder="The map's name"
                                :model.sync="map.name"
                                :has-error="false"
                                :is-disabled="false"
                            ></form-input>

                            <form-select
                                label="Status"
                                name="status"
                                id="status"
                                :model.sync="map.status"
                                :has-error="false"
                                :is-disabled="false"
                                :options="statusOptions"
                                :is-select2="true"
                                select2-options='{ "minimumResultsForSearch": -1 }'
                            ></form-select>

                            <form-textarea
                                label="Description"
                                name="description"
                                id="description"
                                placeholder="The map's name"
                                :model.sync="map.description"
                                :has-error="false"
                                :is-disabled="false"
                            ></form-textarea>

                            <form-select
                                label="Tags"
                                name="tags[]"
                                id="tags"
                                :model.sync="map.tags"
                                :has-error="false"
                                :is-disabled="false"
                                :is-multiple="true"
                                :options="{{ json_encode($tags) }}"
                                :is-select2="false"
                                select2-options='{ "tokenSeparators": [",", " "] }'
                            ></form-select>

                            <!-- <div class="form-group">
                                <label for="tags">Tags</label>
                                {!! Form::select('tags[]',
                                    $tags->lists('name','id'),
                                    old('tags', $map->tags->lists('id')->all()),
                                    [   'id' => 'tags',
                                        'class' => 'form-control select2',
                                        'multiple' => 'multiple',
                                        // 'data-options' => '{ "tags": true, "tokenSeparators": [",", " "] }',
                                        'data-options' => '{ "tokenSeparators": [",", " "] }' ]
                                        ) !!}
                            </div> -->

                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="tab-design">
                            design
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="tab-layers">
                            <div class="callout callout-info">
                                <h4>Save your data</h4>

                                <p>Before proceed, you must save the data.</p>
                            </div>
                        </div>
                        <!-- /.tab-pane -->

                    </div>
                    <!-- /.tab-content -->

                </div>
                <!-- /#controls-view -->

            </form>

        </div>

        <div class="col-sm-12 col-md-7 col-lg-8">
            <div class="box box-solid box-map">
                <div class="box-body">
                    <div id="map-view" class="mapboxgl-map">
                </div>
                <!-- /.box-body -->
            </div>
        </div>

    </div>

</section>
<!-- /.content -->

@stop


@push('postAppScripts')
    <script>
        var map = {!! json_encode($map) !!}
    </script>
    <script src="{{ asset('js/admin/editor.js') }}"></script>
@endpush

