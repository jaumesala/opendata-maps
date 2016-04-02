<form method="POST" action="{{ route('admin.layer.update', $layer->id) }}">
    <input name="_method" type="hidden" value="PUT">
    {{ csrf_field() }}

    <div class="box box-default box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $layer->name }}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
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
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="button" class="btn btn-default btn-xs">Remove</button>
            <div class="pull-right">
                <button type="button" class="btn btn-info btn-xs">Update</button>
            </div>
        </div>
    </div>

</form>