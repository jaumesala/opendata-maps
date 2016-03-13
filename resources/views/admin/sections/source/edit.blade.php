@extends('admin.layouts.admin')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sources
        <small>Edit source information</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.source.index') }}">Sources</a></li>
        <li class="active">Edit</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Page Content -->
    @include('admin.components.form-alerts')

    <div class="row">
        <div class="col-md-7">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit source information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.source.update', $source->id) }}">
                    <input name="_method" type="hidden" value="PUT">
                    {{ csrf_field() }}

                    <div class="box-body">

                        <div class="form-group">
                            <label for="origin_url" class="col-sm-3 control-label">Url</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <p class="form-control-static">{{ str_limit($source->origin_url, 60) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="origin_format" class="col-sm-3 control-label">File type</label>
                            <div class="col-sm-9">
                                <p class="form-control-static" id="origin_format_static">
                                    {{ $source->origin_format }}
                                    <!-- <span class="success hidden"><span class="value"></span> <span class="tail">(guessed)</span></span> -->
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="origin_size" class="col-sm-3 control-label">Size</label>
                            <div class="col-sm-9">
                                <p class="form-control-static" id="origin_size_static" >
                                    {{ number_sizeFormat($source->origin_size) }}
                                    <!-- <span class="success hidden"><span class="value"></span> <span class="tail">(approximately)</span></span> -->
                                </p>
                            </div>
                        </div>
                        @if($errors->has("name")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="name" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $source->name) }}">
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
                                <textarea class="form-control" name="description" id="description" rows="4" placeholder="Give a short description of what we can find in this dataset">{{ old('description', $source->description) }}</textarea>
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
                                    <input type="text" class="form-control" id="web" name="web" placeholder="Web" value="{{ old('web', $source->web) }}">
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
                                    old('sync_interval', $source->sync_interval),
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

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{ route('admin.source.index') }}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-primary pull-right">Update</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>


</section>
<!-- /.content -->

@stop