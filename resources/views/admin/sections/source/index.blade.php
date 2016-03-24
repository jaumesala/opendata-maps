@extends('admin.layouts.admin')


@section('content')

@include('admin.components.form-confirmations')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sources
        <small>Manage your data sources</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sources</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Page Content -->
    @include('admin.components.form-alerts')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <form method="GET" action="{{ route('admin.source.index') }}">
                        <div class="btn-toolbar pull-left" role="toolbar">
                            <div class="btn-group">

                                <?php
                                    $orderDate = 'active';
                                    $orderName = '';
                                    $orderStatus = '';

                                    if(Request::has('order'))
                                    {
                                        $order = Request::input('order');

                                        $orderDate      = ($order == 'created_at') ? 'active' : '';
                                        $orderName      = ($order == 'name') ? 'active' : '';
                                        $orderStatus    = ($order == 'sync_status') ? 'active' : '';
                                    }
                                ?>

                                <a href="{{ route('admin.source.index') }}" class="btn btn-primary {{ $orderDate }}"><i class="fa fa-fw fa-clock-o"></i></a>
                                <a href="{{ route('admin.source.index', [ 'order' => 'name']) }}" class="btn btn-primary {{ $orderName }}"><i class="fa fa-fw fa-sort-alpha-asc"></i></a>
                                <a href="{{ route('admin.source.index', [ 'order' => 'sync_status']) }}" class="btn btn-primary {{ $orderStatus }}"><i class="fa fa-fw fa-line-chart"></i></a>
                            </div>
                            <div class="input-group" style="width:250px;">
                                @if(Request::has('order'))
                                <input type="hidden" name="order" value="{{ Request::input('order','') }}">
                                @endif
                                <input id="query" name="query" type="text" class="form-control" value="{{ Request::input('query','') }}">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </form>
                    <a href="{{ route('admin.source.create') }}" class="btn btn-success pull-right">New Source</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Update</th>
                                <th>Origin</th>
                                <th class="text-right">Size</th>
                                <th>Last sync.</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sources as $source)
                            <tr>
                                <td>{{ $source->name }}</td>
                                <td>
                                    @if($source->sync_status == 'queued')
                                        <span class="label label-info">Queued</span>
                                    @elseif($source->sync_status == 'downloading')
                                        <span class="label label-warning">Downloading</span>
                                    @elseif($source->sync_status == 'downloaded')
                                        <span class="label label-info">Downloaded</span>
                                    @elseif($source->sync_status == 'processing')
                                        <span class="label label-warning">Processing</span>
                                    @elseif($source->sync_status == 'processed')
                                        <span class="label label-info">Processed</span>
                                    @elseif($source->sync_status == 'publishing')
                                        <span class="label label-warning">Publishing</span>
                                    @elseif($source->sync_status == 'error')
                                        <span class="label label-danger">Error</span>
                                    @elseif($source->sync_status == 'ready')
                                        <span class="label label-success">Ready</span>
                                    @elseif($source->sync_status == 'disabled')
                                        <span class="label label-default">Disabled</span>
                                    @else
                                        <span class="label label-default">"{{ $source->sync_status }}"</span>
                                    @endif
                                </td>
                                <td>
                                    @if($source->sync_interval == 'never')
                                        <span class="label label-default" data-toggle="tooltip" data-placement="top" title="Never">N0</span>
                                    @elseif($source->sync_interval == 'yearly')
                                        <span class="label label-default" data-toggle="tooltip" data-placement="top" title="Yearly">Y</span>
                                    @elseif($source->sync_interval == 'monthly')
                                        <span class="label label-default" data-toggle="tooltip" data-placement="top" title="Monthly">M</span>
                                    @elseif($source->sync_interval == 'weekly')
                                        <span class="label label-default" data-toggle="tooltip" data-placement="top" title="Weekly">W</span>
                                    @elseif($source->sync_interval == 'daily')
                                        <span class="label label-default" data-toggle="tooltip" data-placement="top" title="Daily">D</span>
                                    @elseif($source->sync_interval == 'hourly')
                                        <span class="label label-default" data-toggle="tooltip" data-placement="top" title="Hourly">H</span>
                                    @elseif($source->sync_interval == 'onchange')
                                        <span class="label label-default" data-toggle="tooltip" data-placement="top" title="Real Time">RT</span>
                                    @endif
                                </td>
                                <td><span class="label label-default">{{ $source->origin_type }}</span></td>
                                <?php
                                    $size = 'unknown';
                                    if($source->origin_size){
                                        $size = number_sizeFormat($source->origin_size);
                                    }
                                ?>
                                <td class="text-right">{{ $size }}</td>
                                <?php
                                    $date = 'never';
                                    if($source->synced_at){
                                        $date = ts_diffForHumans($source->synced_at);
                                    }
                                ?>
                                <td>{{ $date }}</td>

                                <td class="text-right">
                                    <!-- <div class="btn-group"> -->
                                        @if($source->origin_type != 'file')
                                        <a href="{{ route('admin.source.sync', $source->id) }}" class="btn btn-xs btn-info"><i class="fa fa-refresh"></i> Sync</a>
                                        @endif
                                        <a href="{{ route('admin.source.show', $source->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> Show</a>
                                        {{--
                                        <a href="{{ route('admin.source.edit', $source->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                        <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#confirmDelete" data-id="{{ $source->id }}" data-action="{{ route('admin.source.destroy', $source->id) }}"><i class="fa fa-trash"></i> Delete</button>--}}
                                    <!-- </div> -->
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                <div class="alert alert-warning">
                                    <h4><i class="icon fa fa-warning"></i> Nothing found!</h4>
                                    Your search <strong>{{ Request::input('query','') }}</strong> did not match any source.
                                </div>
                                </td>
                            </tr>

                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php
                    $parameters = [];
                    Request::has('order') ? $parameters['order'] = Request::input('order') : '';
                    Request::has('query') ? $parameters['query'] = Request::input('query') : '';
                    ?>
                    <div class="pull-right">
                        {!! $sources->appends($parameters)->links() !!}
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>

</section>
<!-- /.content -->

@stop