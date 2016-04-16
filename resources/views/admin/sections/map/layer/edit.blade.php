
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

    <form method="POST" action="{{ route('admin.layer.update', $layer->id) }}" class="layerForm">
        <input name="_method" type="hidden" value="PUT">
        {{ csrf_field() }}


        <div class="box-body">

            <input type="hidden" name="map_id" value="{{ $map->id }}">

            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="name-{{ $layer->id }}">Name</label>
                        <input type="text" class="form-control" id="name-{{ $layer->id }}" name="name" placeholder="Layer's name" value="{{ $layer->name }}">
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="visible-{{ $layer->id }}">Visible</label>
                                {!! Form::select('visible',
                                    [   '1' => 'Yes',
                                        '0' => 'No' ],
                                    old('visible', $layer->visible),
                                    [   'id' => 'visible-'.$layer->id,
                                        'class' => 'form-control select2',
                                        'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                        ) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="opacity-{{ $layer->id }}">Opacity</label>
                                {!! Form::selectRange('opacity',
                                    10,0,
                                    old('opacity', $layer->opacity),
                                    [   'id' => 'opacity-'.$layer->id,
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
                        <label for="source_id-{{ $layer->id }}">Source</label>
                        {!! Form::select('source_id',
                            $sources->lists('name', 'id'),
                            old('source_id', $layer->source->id),
                            [   'id' => 'source_id-'.$layer->id,
                                'class' => 'form-control select2',
                                'data-options' => '{ }' ]
                                ) !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="type-{{ $layer->id }}">Type</label>
                        {!! Form::select('type',
                            [   'fill' => 'Fill',
                                'circle' => 'Circle',
                                'line' => 'Line',
                                'choropleth' => 'Choropleth',
                                'heatmap' => 'Heatmap' ],
                            old('type', $layer->type),
                            [   'id' => 'type-'.$layer->id,
                                'class' => 'form-control select2 layerType',
                                'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                ) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="interactive-{{ $layer->id }}">Interactive</label>
                        {!! Form::select('interactive',
                            [   '1' => 'Yes',
                                '0' => 'No' ],
                            old('interactive', $layer->interactive),
                            [   'id' => 'interactive-'.$layer->id,
                                'class' => 'form-control select2',
                                'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                ) !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="minzoom-{{ $layer->id }}">Min Zoom</label>
                        {!! Form::selectRange('minzoom',
                            0,22,
                            old('minzoom', $layer->minzoom),
                            [   'id' => 'minzoom-'.$layer->id,
                                'class' => 'form-control select2',
                                'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                ) !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="maxzoom-{{ $layer->id }}">Max Zoom</label>
                        {!! Form::selectRange('maxzoom',
                            0,22,
                            old('maxzoom', $layer->maxzoom),
                            [   'id' => 'maxzoom-'.$layer->id,
                                'class' => 'form-control select2',
                                'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                ) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="paint-{{ $layer->id }}">Paint values</label>

                        <div class="sublist-wrapper paintRules">

                            <?php

                                $paintOptions = [
                                    [   'type' => 'input',
                                        'name' => 'color',
                                        'label' => 'Color',
                                        'filter' => [ 'fill', 'line', 'circle' ],
                                        'class' => 'colorpicker',
                                        'placeholder' => '#000000',
                                    ],
                                    [   'type' => 'input',
                                        'name' => 'outline-color',
                                        'label' => 'Outline Color',
                                        'filter' => [ 'fill' ],
                                        'class' => 'colorpicker',
                                        'placeholder' => '#000000',
                                    ],
                                    [   'type' => 'input',
                                        'name' => 'width',
                                        'label' => 'width',
                                        'filter' => [ 'line' ],
                                        'class' => '',
                                        'placeholder' => '2',
                                    ],
                                    [   'type' => 'input',
                                        'name' => 'gap-width',
                                        'label' => 'Gap width',
                                        'filter' => [ 'line' ],
                                        'class' => '',
                                        'placeholder' => '3',
                                    ],
                                    [   'type' => 'input',
                                        'name' => 'dasharray',
                                        'label' => 'Dash array',
                                        'filter' => [ 'line' ],
                                        'class' => '',
                                        'placeholder' => '2,3',
                                    ],
                                    [   'type' => 'input',
                                        'name' => 'radius',
                                        'label' => 'Radius',
                                        'filter' => [ 'circle' ],
                                        'class' => '',
                                        'placeholder' => '10',
                                    ],
                                    [   'type' => 'input',
                                        'name' => 'blur',
                                        'label' => 'Blur',
                                        'filter' => [ 'line', 'circle' ],
                                        'class' => '',
                                        'placeholder' => '3',
                                    ],
                                    [   'type' => 'input',
                                        'name' => 'choropleth-color',
                                        'label' => 'Color schema',
                                        'filter' => [ 'choropleth' ],
                                        'class' => '',
                                        'placeholder' => 'RdYlBu',
                                    ],
                                    [   'type' => 'select',
                                        'name' => 'choropleth-reverse',
                                        'label' => 'Reverse colors',
                                        'filter' => [ 'choropleth' ],
                                        'list' => [0 => 'No', 1 => 'Yes'],
                                        'class' => '',
                                        'placeholder' => 'Reverse colors',
                                    ],

                                ];

                            ?>

                            @foreach($paintOptions as $option)
                                @include('admin.sections.map.layer.option.show', $option)
                            @endforeach

                        </div> <!-- /.sublist-wrapper -->

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="filter">Layout values</label>

                        <div class="sublist-wrapper layoutRules">

                            <?php

                                $layoutOptions = [
                                    [   'type' => 'sources',
                                        'name' => 'choropleth-source',
                                        'label' => 'Group by',
                                        'filter' => [ 'choropleth' ],
                                        'list' => $sources->lists('name', 'hash'),
                                        'class' => '',
                                        'placeholder' => 'Choose a source',
                                    ],
                                    [   'type' => 'select',
                                        'name' => 'choropleth-classes',
                                        'label' => 'Num. of groups',
                                        'filter' => [ 'choropleth' ],
                                        'list' => [3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9],
                                        'class' => '',
                                        'placeholder' => 'How many divisions',
                                    ],
                                ];

                            ?>

                            @foreach($layoutOptions as $option)
                                @include('admin.sections.map.layer.option.show', $option)
                            @endforeach

                        </div>

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

