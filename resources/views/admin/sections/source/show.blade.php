@extends('admin.layouts.admin')


@section('content')

@include('admin.components.form-confirmations')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sources
        <small>View source information</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.source.index') }}">Sources</a></li>
        <li class="active">View</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Page Content -->
    @include('admin.components.form-alerts')

    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit source information</h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body form-horizontal">

                    <div class="form-group">
                        <label for="origin_url" class="col-sm-3 control-label">Url</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><a target="_blank" href="{{ $source->origin_url }}">{{ str_limit($source->origin_url, 50) }} <i class="fa fa-fw fa-external-link"></i></a></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="origin_format" class="col-sm-3 control-label">File type</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">
                                {{ $source->origin_format }}
                                <!-- <span class="success hidden"><span class="value"></span> <span class="tail">(guessed)</span></span> -->
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="origin_size" class="col-sm-3 control-label">Size</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">
                                {{ number_sizeFormat($source->origin_size) }}
                                <!-- <span class="success hidden"><span class="value"></span> <span class="tail">(approximately)</span></span> -->
                            </p>
                        </div>
                    </div>
                    @if($errors->has("name")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                        <label for="name" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $source->name }}</p>
                        </div>
                    </div>
                    @if($errors->has("description")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $source->description }}</p>
                        </div>
                    </div>
                    @if($errors->has("web")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                        <label for="web" class="col-sm-3 control-label">Website</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><a target="_blank" href="{{ $source->web}}">{{ str_limit($source->web, 50) }} <i class="fa fa-fw fa-external-link"></i></a></p>
                        </div>
                    </div>
                    @if($errors->has("sync_interval")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                        <label for="sync_interval" class="col-sm-3 control-label">Update it</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">
                                <?php
                                    $intervals = [
                                        'never' => 'Never',
                                        'yearly' => 'Once per year',
                                        'monthly' => 'Once per month',
                                        'weekly' => 'Every week',
                                        'daily' => 'Every day',
                                        'onchange' => 'Upon change ( close to real time)'
                                    ];
                                ?>
                                {{ $intervals[$source->sync_interval] }}
                            </p>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <!-- form start -->
                    <button class="btn btn-danger" data-toggle="modal" data-target="#confirmDelete" data-id="{{ $source->id }}" data-action="{{ route('admin.source.destroy', $source->id) }}">Delete</button>
                    <a href="{{ route('admin.source.edit', $source->id) }}" class="btn btn-primary pull-right">Edit</a>

                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>

        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Historical records</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            @forelse($records as $record)
                            <?php
                                switch($record->level){
                                    case "success":
                                        $level = "text-green";
                                        break;
                                    case "info":
                                        $level = "text-aqua";
                                        break;
                                    case "warning":
                                        $level = "text-yellow";
                                        break;
                                    case "error":
                                        $level = "text-red";
                                        break;
                                    default:
                                        $level = "text-muted";
                                }
                            ?>
                            <tr class="{{ $level }}">
                                <?php
                                    // $date = Carbon::createFromFormat('Y-m-d H:i:s', $record->created_at);
                                    // $date->diffForHumans();
                                ?>
                                <td>{{ $record->created_at }} - {{ $record->message }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td>There are no records to display.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
                <div class="box-footer">

                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>

    </div>


</section>
<!-- /.content -->

@stop