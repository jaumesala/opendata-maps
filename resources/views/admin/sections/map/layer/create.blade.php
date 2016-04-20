@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul class="list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form method="POST" action="{{ route('admin.layer.store') }}">
    {{ csrf_field() }}

    <div class="box box-success box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">New layer</h3>
            {{--
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            --}}
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <input type="hidden" name="map_id" value="{{ $map->id }}">

            <div class="row">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Layer's name" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="visible-0">Visible</label>
                                {!! Form::select('visible',
                                    [   '1' => 'Yes',
                                        '0' => 'No' ],
                                    old('visible'),
                                    [   'id' => 'visible-0',
                                        'class' => 'form-control select2',
                                        'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                        ) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="opacity-0">Opacity</label>
                                {!! Form::selectRange('opacity',
                                    10,0,
                                    old('opacity'),
                                    [   'id' => 'opacity-0',
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
                        <label for="source_id-0">Source</label>
                        {!! Form::select('source_id',
                            $sources->lists('name', 'id'),
                            old('source_id'),
                            [   'id' => 'source_id-0',
                                'class' => 'form-control select2',
                                'data-options' => '{ }' ]
                                ) !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="type-0">Type</label>
                        {!! Form::select('type',
                            [   'fill' => 'Fill',
                                'circle' => 'Circle',
                                'line' => 'Line',
                                'choropleth' => 'Choropleth',
                                'heatmap' => 'Heatmap' ],
                            old('type'),
                            [   'id' => 'type-0',
                                'class' => 'form-control select2 layerType',
                                'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                ) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="interactive-0">Interactive</label>
                        {!! Form::select('interactive',
                            [   '1' => 'Yes',
                                '0' => 'No' ],
                            old('interactive'),
                            [   'id' => 'interactive-0',
                                'class' => 'form-control select2',
                                'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                ) !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="minzoom-0">Min Zoom</label>
                        {!! Form::selectRange('minzoom',
                            0,22,
                            old('minzoom', 0),
                            [   'id' => 'minzoom-0',
                                'class' => 'form-control select2',
                                'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                ) !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="maxzoom-0">Max Zoom</label>
                        {!! Form::selectRange('maxzoom',
                            0,22,
                            old('maxzoom', 22),
                            [   'id' => 'maxzoom-0',
                                'class' => 'form-control select2',
                                'data-options' => '{ "minimumResultsForSearch": -1 }' ]
                                ) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="paint-0">Paint values</label>

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
                                        'filter' => [ 'circle', 'heatmap' ],
                                        'class' => '',
                                        'placeholder' => '10',
                                    ],
                                    [   'type' => 'input',
                                        'name' => 'blur',
                                        'label' => 'Blur',
                                        'filter' => [ 'line', 'circle', 'heatmap' ],
                                        'class' => '',
                                        'placeholder' => '3',
                                    ],
                                    [   'type' => 'input',
                                        'name' => 'schema-color',
                                        'label' => 'Color schema',
                                        'filter' => [ 'choropleth', 'heatmap' ],
                                        'class' => '',
                                        'placeholder' => 'RdYlBu',
                                    ],
                                    [   'type' => 'select',
                                        'name' => 'schema-reverse',
                                        'label' => 'Reverse colors',
                                        'filter' => [ 'choropleth', 'heatmap' ],
                                        'list' => [0 => 'No', 1 => 'Yes'],
                                        'class' => '',
                                        'placeholder' => 'Reverse colors',
                                    ],

                                ];

                            ?>

                            @foreach($paintOptions as $option)
                                @include('admin.sections.map.layer.option.show', $option)
                            @endforeach

                        </div>

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
                                        'name' => 'clusters',
                                        'label' => 'Num. of groups',
                                        'filter' => [ 'choropleth', 'heatmap' ],
                                        'list' => [3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9],
                                        'class' => '',
                                        'placeholder' => 'How many divisions',
                                    ],
                                    [   'type' => 'input',
                                        'name' => 'cluster-maxzoom',
                                        'label' => 'Cluster max zoom',
                                        'filter' => [ 'heatmap' ],
                                        'list' => [22 => 22, 21 => 21, 20 => 20, 19 => 19, 18 => 18, 17 => 17, 16 => 16, 15 => 15, 14 => 14, 13 => 13, 12 => 12, 11 => 11, 10 => 10],
                                        'class' => '',
                                        'placeholder' => 'zoom where to stop clustering',
                                    ],
                                    [   'type' => 'input',
                                        'name' => 'cluster-radius',
                                        'label' => 'Cluster radius',
                                        'filter' => [ 'heatmap' ],
                                        'class' => '',
                                        'placeholder' => '20',
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
            <button type="button" class="btn btn-default btn-xs">Cancel</button>
            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-xs">Create</button>
            </div>
        </div>
    </div>

</form>