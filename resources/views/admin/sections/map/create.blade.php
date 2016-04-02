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
                                        'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                        ) !!}
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5" v-model="map.description">{{ old('description', null) }}</textarea>
                            </div>

                            @if($errors->has("tags")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                <label for="tags">Tags</label>
                                {!! Form::select('tags[]',
                                    $tags->lists('name','id'),
                                    old('tags', null),
                                    [   'id' => 'tags',
                                        'class' => 'form-control select2',
                                        'multiple' => 'multiple',
                                        // 'data-options' => '{ "tags": true, "tokenSeparators": [",", " "] }',
                                        'data-options' => '{ "tokenSeparators": [",", " "] }' ]
                                        ) !!}
                                @if ($errors->has("tags"))
                                    <p class="help-block">
                                        {{ $errors->first("tags") }}
                                    </p>
                                @endif
                            </div>

                            <div class="form-group">
                                <hr>
                                <button type="submit" class="btn btn-block btn-success">save</button>
                            </div>

                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="tab-design">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Style</label>
                                        {!! Form::select('style',
                                            [],
                                            old('style', null),
                                            [   'id' => 'style',
                                                'class' => 'form-control select2',
                                                'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                                ) !!}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    @if($errors->has("zoom")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                        <label for="zoom">Zoom</label>
                                        <input type="text" name="zoomDisabled" id="zoomDisabled" value="{{ old('zoom', setting_value('maps', 'defaultZoom') ) }}" class="slider form-control" data-slider-min="1" data-slider-max="20" data-slider-value="{{ old('zoom', setting_value('maps', 'defaultZoom') ) }}" data-slider-tooltip="always" disabled>
                                        <input type="hidden" name="zoom" id="zoom" value="{{ old('zoom', setting_value('maps', 'defaultZoom') ) }}">
                                        @if ($errors->has("zoom"))
                                            <p class="help-block">
                                                {{ $errors->first("zoom") }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    @if($errors->has("longitude")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                        <label for="longitude">Longitude</label>
                                        <input type="text" class="form-control" id="longitudeDisabled" name="longitudeDisabled" placeholder="The map's longitude" value="{{ old('longitude', setting_value('maps', 'defaultLongitude') ) }}" disabled>
                                        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', setting_value('maps', 'defaultLongitude') ) }}">
                                        @if ($errors->has("longitude"))
                                            <p class="help-block">
                                                {{ $errors->first("longitude") }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    @if($errors->has("latitude")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                        <label for="latitude">Latitude</label>
                                        <input type="text" class="form-control" id="latitudeDisabled" name="latitudeDisabled" placeholder="The map's latitude" value="{{ old('latitude', setting_value('maps', 'defaultLatitude')) }}" disabled>
                                        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', setting_value('maps', 'defaultLatitude')) }}">
                                        @if ($errors->has("latitude"))
                                            <p class="help-block">
                                                {{ $errors->first("latitude") }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    @if($errors->has("pitch")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                        <label for="pitch">Pitch</label>
                                        <input type="text" name="pitchDisabled" id="pitchDisabled" value="{{ old('pitch', setting_value('maps', 'defaultPitch') ) }}" class="slider form-control" data-slider-min="0" data-slider-max="60" data-slider-value="{{ old('pitch', setting_value('maps', 'defaultPitch') ) }}" disabled>
                                        <input type="hidden" name="pitch" id="pitch" value="{{ old('pitch', setting_value('maps', 'defaultPitch') ) }}">
                                        @if ($errors->has("pitch"))
                                            <p class="help-block">
                                                {{ $errors->first("pitch") }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    @if($errors->has("bearing")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                        <label for="bearing">Bearing</label>
                                        <input type="text" name="bearingDisabled" id="bearingDisabled" value="{{ old('bearing', setting_value('maps', 'defaultBearing') ) }}" class="slider form-control" data-slider-min="0" data-slider-max="360" data-slider-value="{{ old('bearing', setting_value('maps', 'defaultBearing') ) }}" disabled>
                                        <input type="hidden" name="bearing" id="bearing" value="{{ old('bearing', setting_value('maps', 'defaultBearing') ) }}">
                                        @if ($errors->has("bearing"))
                                            <p class="help-block">
                                                {{ $errors->first("bearing") }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <hr>
                                <button type="submit" class="btn btn-block btn-success">save</button>
                            </div>

                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="tab-layers">
                            <div class="callout callout-info">
                                <h4>Save your data</h4>
                                <p>Before proceed, you must save the data.</p>
                            </div>
                            <div class="form-group">
                                <hr>
                                <button type="submit" class="btn btn-block btn-success">save</button>
                            </div>
                        </div>
                        <!-- /.tab-pane -->

                    </div>
                    <!-- /.tab-content -->

                </div>
                <!-- /#controls-view -->
            </div>

        </form>

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