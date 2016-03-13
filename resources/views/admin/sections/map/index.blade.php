@extends('admin.layouts.admin')


@section('content')

@include('admin.components.form-confirmations')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Maps
        <small>Manage your maps</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Maps</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Page Content -->
    @include('admin.components.form-alerts')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <form method="GET" action="{{ route('admin.map.index') }}">
                        <div class="btn-toolbar pull-left" role="toolbar">
                            <div class="btn-group">
                                <?php
                                    $orderDate  = Request::has('order') ? '' : 'active';
                                    $orderCount = Request::has('order') ? 'active' : '';
                                ?>
                                <a href="{{ route('admin.map.index') }}" class="btn btn-primary {{ $orderDate }}"><i class="fa fa-fw fa-clock-o"></i></a>
                                <a href="{{ route('admin.map.index', [ 'order' => 'views']) }}" class="btn btn-primary {{ $orderCount }}"><i class="fa fa-fw fa-line-chart"></i></a>
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

                    <a href="#" class="btn btn-success pull-right">New Map</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        @forelse($maps as $map)
        <div class="col-sm-12 col-md-6 col-lg-4">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-black" style="background: url({{ asset('img/admin/maps/default.jpg') }}) center center;">
                    <h3 class="widget-user-username">{{ $map->name }}</h3>
                    <?php
                        $createdAt  = $map->created_at;
                        $date       = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt);
                    ?>
                    <h6 class="widget-user-desc">
                        @if($map->status == 'public')
                            <i class="fa fa-circle text-success margin-r-5"></i>
                        @elseif($map->status == 'private')
                            <i class="fa fa-circle text-warning margin-r-5"></i>
                        @elseif($map->status == 'disabled')
                            <i class="fa fa-circle text-danger margin-r-5"></i>
                        @else
                            <i class="fa fa-circle text-danger margin-r-5"></i>
                        @endif
                        By {{ $map->user->name }}, {{ $date->diffForHumans() }}
                    </h6>
                </div>
                <div class="box-footer">
                    <div class="row">

                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ number_format($map->views, 0, ',', '.') }}</h5>
                                <span class="description-text">Views</span>
                            </div>
                        </div>

                        <div class="col-sm-8">
                            <div class="description-block">
                                <a href="{{ route('admin.map.show', $map->id) }}" class="btn btn-default pull-left"><i class="fa fa-fw fa-eye"></i></a>
                                <div class="btn-group pull-right">
                                    <a href="{{ route('admin.map.edit', $map->id) }}" class="btn btn-default"><i class="fa fa-fw fa-pencil"></i> Edit</a>
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#"><i class="fa fa-fw fa-ban"></i> Disable</a></li>
                                        <li><a href="#"><i class="fa fa-fw fa-share-alt"></i> Share</a></li>
                                        <li><a href="#"><i class="fa fa-fw fa-files-o"></i> Duplicate</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#"><i class="fa fa-fw fa-trash-o"></i> Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">13,000</h5>
                                <span class="description-text">FOLLOWERS</span>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">35</h5>
                                <span class="description-text">PRODUCTS</span>
                            </div>
                        </div> -->

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.widget-user -->

        </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-warning">
                <h4><i class="icon fa fa-warning"></i> Nothing found!</h4>
                Your search <strong>{{ Request::input('query','') }}</strong> did not match any map.
              </div>
            </div>
        @endforelse

        <div class="col-md-12">

            <?php
            $parameters = [];
            Request::has('order') ? $parameters['order'] = Request::input('order') : '';
            Request::has('query') ? $parameters['query'] = Request::input('query') : '';
            ?>
            <div class="pull-right">
                {!! $maps->appends($parameters)->links() !!}
            </div>
        </div>
    </div>



</section>
<!-- /.content -->

@stop