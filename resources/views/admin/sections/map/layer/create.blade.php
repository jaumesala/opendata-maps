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
                                'line' => 'Line' ],
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
                            old('minzoom'),
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
                            old('maxzoom'),
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
                                    [   'name' => 'color',
                                        'label' => 'Color',
                                        'filter' => [ 'fill', 'line', 'circle' ],
                                        'class' => 'colorpicker',
                                        'placeholder' => '#000000',
                                    ],
                                    [   'name' => 'outline-color',
                                        'label' => 'Outline Color',
                                        'filter' => [ 'fill' ],
                                        'class' => 'colorpicker',
                                        'placeholder' => '#000000',
                                    ],
                                    [   'name' => 'width',
                                        'label' => 'width',
                                        'filter' => [ 'line' ],
                                        'class' => '',
                                        'placeholder' => '2',
                                    ],
                                    [   'name' => 'gap-width',
                                        'label' => 'Gap width',
                                        'filter' => [ 'line' ],
                                        'class' => '',
                                        'placeholder' => '3',
                                    ],
                                    [   'name' => 'dasharray',
                                        'label' => 'Dash array',
                                        'filter' => [ 'line' ],
                                        'class' => '',
                                        'placeholder' => '2,3',
                                    ],
                                    [   'name' => 'radius',
                                        'label' => 'Radius',
                                        'filter' => [ 'circle' ],
                                        'class' => '',
                                        'placeholder' => '10',
                                    ],
                                    [   'name' => 'blur',
                                        'label' => 'Blur',
                                        'filter' => [ 'circle' ],
                                        'class' => '',
                                        'placeholder' => '3',
                                    ],

                                ];

                            ?>

                            @foreach($paintOptions as $option)
                            <div class="form-group input-group-xs clearfix" data-filter="{{ implode(" ", $option['filter']) }}">
                                <div class="col-xs-7">
                                    <div class="row">
                                        <label for="{{ $option['name']."-0" }}" class="control-label">{{ $option['label'] }}</label>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <div class="row">
                                        <input type="text" class="form-control {{ $option['class'] }}" id="{{ $option['name']."-0" }}" name="{{ $option['name'] }}" placeholder="{{ $option['placeholder'] }}">
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="filter">Layout values</label>

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