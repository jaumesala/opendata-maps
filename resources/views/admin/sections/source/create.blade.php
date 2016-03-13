@extends('admin.layouts.admin')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sources
        <small>Create a new source</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.source.index') }}">Sources</a></li>
        <li class="active">Create</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Page Content -->
    @include('admin.components.form-alerts')

    <div class="row">
        <div class="col-md-12">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab-url" data-toggle="tab" aria-expanded="true"><i class="fa fa-fw fa-link"></i> Url link</a>
                    </li>
                    <li>
                        <a href="#tab-file" data-toggle="tab" aria-expanded="false"><i class="fa fa-fw fa-file-text-o"></i> Upload file</a>
                    </li>
                    <li>
                        <a href="#tab-dropbox" data-toggle="tab" aria-expanded="false"><i class="fa fa-fw fa-dropbox"></i> Dropbox</a>
                    </li>
                    <li>
                        <a href="#tab-gdrive" data-toggle="tab" aria-expanded="false"><i class="fa fa-fw fa-google"></i> Google Drive</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-url">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="text-center">
                                    <h4>Get data from an external url link</h4>
                                    <p>Paste the full url to the resource file. CSV, KML, GPX or GeoJSON</p>
                                    <br>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-5 col-md-offset-3">
                                <form method="POST" action="{{ route('admin.source.store', '#tab-url') }}" class="form-horizontal">
                                {{ csrf_field() }}
                                    <input type="hidden" name="origin_type" value="url">

                                    @if($errors->has("origin_url")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                        <label for="origin_url" class="col-sm-3 control-label">Url</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="origin_url" name="origin_url" placeholder="Url" value="{{ old('origin_url') }}">
                                                <span class="input-group-btn">
                                                    <button disabled class="btn btn-info" data-url="{{ route('admin.source.url.check') }}" id="origin_url_check" type="button"><span class="text">Check</span><span class="spin hidden"><i class="fa fa-fw fa-spinner fa-spin"></i></span></button>
                                                </span>
                                            </div>
                                            @if ($errors->has("origin_url"))
                                                <p class="help-block">
                                                    {{ $errors->first("origin_url") }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($errors->has("origin_format")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                        <label for="origin_format" class="col-sm-3 control-label">File type</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-static" id="origin_format_static">
                                                -
                                                <!-- <span class="unknown">Unknown</span>
                                                <span class="undetermined hidden">We could not find out</span>
                                                <span class="success hidden"><span class="value"></span> <span class="tail">(guessed)</span></span> -->
                                            </p>
                                            @if ($errors->has("origin_format"))
                                                <p class="help-block">
                                                    {{ $errors->first("origin_format") }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($errors->has("origin_size")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                        <label for="origin_size" class="col-sm-3 control-label">Size</label>
                                        <div class="col-sm-9">
                                            <p class="form-control-static" id="origin_size_static" >
                                                -
                                                <!-- <span class="unknown">Unknown</span>
                                                <span class="undetermined hidden">We could not find out</span>
                                                <span class="success hidden"><span class="value"></span> <span class="tail">(approximately)</span></span> -->
                                            </p>
                                            @if ($errors->has("origin_size"))
                                                <p class="help-block">
                                                    {{ $errors->first("origin_size") }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($errors->has("name")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                        <label for="name" class="col-sm-3 control-label">Name</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                                                <div class="input-group-addon"><i class="fa fa-fw fa-info-circle" data-toggle="tooltip" data-placement="top" title="A descriptive name to understand what this source is"></i></div>
                                            </div>
                                            @if ($errors->has("name"))
                                                <p class="help-block">
                                                    {{ $errors->first("name") }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($errors->has("description")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                        <label for="description" class="col-sm-3 control-label">Description</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="description" id="description" rows="4" placeholder="Give a short description of what we can find in this dataset">{{ old('description') }}</textarea>
                                            @if ($errors->has("description"))
                                                <p class="help-block">
                                                    {{ $errors->first("description") }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($errors->has("web")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                        <label for="web" class="col-sm-3 control-label">Website</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="web" name="web" placeholder="Web" value="{{ old('web') }}">
                                                <div class="input-group-addon"><i class="fa fa-fw fa-info-circle" data-toggle="tooltip" data-placement="top" title="Website where we can find more information about the dataset"></i></div>
                                            </div>
                                            @if ($errors->has("web"))
                                                <p class="help-block">
                                                    {{ $errors->first("web") }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($errors->has("sync_interval")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                                        <label for="sync_interval" class="col-sm-3 control-label">Update it</label>
                                        <div class="col-sm-9">
                                            {!! Form::select('sync_interval',
                                                [   'never' => 'Never',
                                                    'yearly' => 'Once per year',
                                                    'monthly' => 'Once per month',
                                                    'weekly' => 'Every week',
                                                    'daily' => 'Every day',
                                                    'onchange' => 'Upon change ( close to real time)' ],
                                                old('sync_interval', null),
                                                [   'id' => 'sync_interval',
                                                    'class' => 'form-control select2' ]
                                                    ) !!}
                                            @if ($errors->has("sync_interval"))
                                                <p class="help-block">
                                                    {{ $errors->first("sync_interval") }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- <button type="submit" class="btn btn-default">Cancel</button> -->
                                    <button type="submit" class="btn btn-success pull-right">Connect source</button>
                                </form>

                            </div>

                        </div>
                        <br>
                        <br>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab-file">
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <p class="lead text-center">Work in progress...</p>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab-dropbox">
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <p class="lead text-center">Work in progress...</p>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab-gdrive">
                        <div class="row">
                            <div class="col-md-12">
                                <br>
                                <p class="lead text-center">Work in progress...</p>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>

        </div>

    </div>

</section>
<!-- /.content -->

@stop