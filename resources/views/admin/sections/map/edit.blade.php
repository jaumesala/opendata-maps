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



                <div id="controls-view" class="nav-tabs-custom">

                    <ul class="nav nav-tabs">
                        <li><a href="#tab-info" data-toggle="tab">Info</a></li>
                        <li><a href="#tab-design" data-toggle="tab">Design</a></li>
                        <li class="active"><a href="#tab-layers" data-toggle="tab">Layers</a></li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane" id="tab-info">
                            <form method="POST" action="{{ route('admin.map.update', $map->id) }}" >
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="PUT">
                                <input type="hidden" name="_section" value="info"/>

                                @if($errors->has("name")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="The map's name" value="{{ old('name', $map->name) }}">
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
                                        old('status', $map->status),
                                        [   'id' => 'status',
                                            'class' => 'form-control select2',
                                            'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                            ) !!}
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $map->description) }}</textarea>
                                </div>

                                @if($errors->has("tags")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                    <label for="tags">Tags</label>
                                    {!! Form::select('tags[]',
                                        $tags->lists('name','id'),
                                        old('tags', $map->tags->lists('id', 'name')->all()),
                                        [   'id' => 'tags',
                                            'class' => 'form-control select2',
                                            'multiple' => 'multiple',
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
                            </form>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane" id="tab-design">
                            <form method="POST" action="{{ route('admin.map.update', $map->id) }}" >
                                {{ csrf_field() }}
                                <input name="_method" type="hidden" value="PUT">
                                <input type="hidden" name="_section" value="design">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name">Style</label>
                                            {!! Form::select('style',
                                                [],
                                                old('style', null),
                                                [   'id' => 'style',
                                                    'class' => 'form-control select2',
                                                    'data-options' => '{ "minimumResultsForSearch": -1 }']
                                                    ) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        @if($errors->has("zoom")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                            <label for="zoom">Zoom</label>
                                            <input type="text" name="zoomDisabled" id="zoomDisabled" value="{{ old('zoom', $map->zoom ) }}" class="slider form-control" disabled>
                                            <input type="hidden" name="zoom" id="zoom" value="{{ old('zoom', $map->zoom ) }}">
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
                                            <input type="text" class="form-control" id="longitudeDisabled" name="longitudeDisabled" placeholder="The map's longitude" value="{{ old('longitude', $map->longitude ) }}" disabled>
                                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $map->longitude ) }}">
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
                                            <input type="text" class="form-control" id="latitudeDisabled" name="latitudeDisabled" placeholder="The map's latitude" value="{{ old('latitude', $map->latitude) }}" disabled>
                                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $map->latitude) }}">
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
                                            <input type="text" name="pitchDisabled" id="pitchDisabled" value="{{ old('pitch', $map->pitch ) }}" class="slider form-control" disabled>
                                            <input type="hidden" name="pitch" id="pitch" value="{{ old('pitch', $map->pitch ) }}">
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
                                            <input type="text" name="bearingDisabled" id="bearingDisabled" value="{{ old('bearing', $map->bearing ) }}" class="slider form-control" disabled>
                                            <input type="hidden" name="bearing" id="bearing" value="{{ old('bearing', $map->bearing ) }}">
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

                            </form>

                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane active" id="tab-layers">

                            <div id="layers">

                                {{-- Edit layers --}}
                                @foreach ($map->layers as $layer)
                                    <?php
                                        $data = compact('sources', 'layer', 'map')
                                    ?>
                                    @include('admin.sections.map.layer.edit', $data)
                                @endforeach
                                {{-- /Edit layers --}}

                            </div>

                            <div id="new-layer">
                                <?php
                                    $data = compact('sources', 'map')
                                ?>
                                @include('admin.sections.map.layer.create', $data)

                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-info btn-block">Add a new layer</button>
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

