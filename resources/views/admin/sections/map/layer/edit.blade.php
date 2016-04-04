
<?php
    if(Session::get('activeLayer') == $layer->id)
    {
        $class = '';
        $icon = 'fa-minus';
    }
    else
    {
        $class = 'collapsed-box';
        $icon = 'fa-plus';
    }
?>

<div id="{{ "layer-$layer->id" }}" class="box box-default box-solid {{ $class }}">

    <div class="box-header with-border">
        <h3 class="box-title">{{ $layer->name }}</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa {{ $icon }}"></i></button>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->

    <form method="POST" action="{{ route('admin.layer.update', $layer->id) }}">
        <input name="_method" type="hidden" value="PUT">
        {{ csrf_field() }}


        <div class="box-body">

            <input type="hidden" name="map_id" value="{{ $map->id }}">

            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Layer's name" value="{{ $layer->name }}">
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="visible">Visible</label>
                                {!! Form::select('visible',
                                    [   '1' => 'Yes',
                                        '0' => 'No' ],
                                    old('visible', $layer->visible),
                                    [   'id' => 'visible',
                                        'class' => 'form-control select2',
                                        'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                        ) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="opacity">Opacity</label>
                                {!! Form::selectRange('opacity',
                                    10,0,
                                    old('opacity', $layer->opacity),
                                    [   'id' => 'opacity',
                                        'class' => 'form-control select2',
                                        'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                        ) !!}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="source">Source</label>
                        {!! Form::select('source_id',
                            $sources->lists('name', 'id'),
                            old('source_id', $layer->source->id),
                            [   'id' => 'source_id',
                                'class' => 'form-control select2',
                                'data-options' => '{ }' ]
                                ) !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="visible">Type</label>
                        {!! Form::select('type',
                            [   'fill' => 'Fill',
                                'circle' => 'Circle',
                                'line' => 'Line' ],
                            old('type', $layer->type),
                            [   'id' => 'type',
                                'class' => 'form-control select2',
                                'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                ) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="interactive">Interactive</label>
                        {!! Form::select('interactive',
                            [   '1' => 'Yes',
                                '0' => 'No' ],
                            old('interactive', $layer->interactive),
                            [   'id' => 'interactive',
                                'class' => 'form-control select2',
                                'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                ) !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="minzoom">Min Zoom</label>
                        {!! Form::selectRange('minzoom',
                            0,22,
                            old('minzoom', $layer->minzoom),
                            [   'id' => 'minzoom',
                                'class' => 'form-control select2',
                                'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                ) !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="maxzoom">Max Zoom</label>
                        {!! Form::selectRange('maxzoom',
                            0,22,
                            old('maxzoom', $layer->maxzoom),
                            [   'id' => 'maxzoom',
                                'class' => 'form-control select2',
                                'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                ) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="paint">Paint values</label>
                        <textarea class="form-control" rows="3" name="paint" id="paint">{{ old('paint', $layer->paint) }}</textarea>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="filter">Filter values</label>
                        <textarea class="form-control" rows="3" name="filter" id="filter">{{ old('filter', $layer->filter) }}</textarea>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="button" data-toggle="modal" data-target="#confirmDelete" data-id="{{ $layer->id }}" data-action="{{ route('admin.layer.destroy', $layer->id) }}" class="btn btn-danger btn-xs">Remove</button>
            <div class="pull-right">
                <button type="submit" class="btn btn-info btn-xs">Update</button>
            </div>
        </div>

    </form>

</div>

