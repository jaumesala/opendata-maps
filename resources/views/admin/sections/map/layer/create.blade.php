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
                                <label for="visible">Visible</label>
                                {!! Form::select('visible',
                                    [   '1' => 'Yes',
                                        '0' => 'No' ],
                                    old('visible'),
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
                                    old('opacity'),
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
                            old('source_id'),
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
                            old('type'),
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
                            old('interactive'),
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
                            old('minzoom'),
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
                            old('maxzoom'),
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
                        <textarea class="form-control" rows="3" name="paint" id="paint">{{ old('paint') }}</textarea>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="filter">Filter values</label>
                        <textarea class="form-control" rows="3" name="filter" id="filter">{{ old('filter') }}</textarea>
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