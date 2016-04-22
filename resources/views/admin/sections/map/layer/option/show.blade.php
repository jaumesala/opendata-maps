<?php
    $layerId = 0;
    $optionName = '';

    if(isset($layer))
    {
        $layerId = $layer->id;
        $optionName = $layer->{$option['name']};
    }

?>
@if($option['type'] == 'sources')
    <div class="form-group input-group-xs clearfix" data-filter="{{ implode(" ", $option['filter']) }}">
        <div class="col-xs-4">
            <div class="row">
                <label for="{{ $option['name']."-".$layerId }}" class="control-label">{{ $option['label'] }}</label>
            </div>
        </div>
        <div class="col-xs-8">
            <div class="row">
                {!! Form::select($option['name'],
                    $option['list'],
                    old($option['name'], $optionName),
                    [   'id' => $option['name']."-".$layerId,
                        'class' => 'form-control select2',
                        'data-options' => '{ "containerCssClass" : "select2-container-xs", "dropdownCssClass" : "select2-dropdown-xs"  }' ]
                        ) !!}
            </div>
        </div>
    </div>
@elseif($option['type'] == 'select')
    <div class="form-group input-group-xs clearfix" data-filter="{{ implode(" ", $option['filter']) }}">
        <div class="col-xs-7">
            <div class="row">
                <label for="{{ $option['name']."-".$layerId }}" class="control-label">{{ $option['label'] }}</label>
            </div>
        </div>
        <div class="col-xs-5">
            <div class="row">
                {!! Form::select($option['name'],
                    $option['list'],
                    old($option['name'], $optionName),
                    [   'id' => $option['name']."-".$layerId,
                        'class' => 'form-control select2',
                        'data-options' => '{ "minimumResultsForSearch": -1, "containerCssClass" : "select2-container-xs", "dropdownCssClass" : "select2-dropdown-xs"  }' ]
                        ) !!}
            </div>
        </div>
    </div>
@else
    <div class="form-group input-group-xs clearfix" data-filter="{{ implode(" ", $option['filter']) }}">
        <div class="col-xs-7">
            <div class="row">
                <label for="{{ $option['name']."-".$layerId }}" class="control-label">{{ $option['label'] }}</label>
            </div>
        </div>
        <div class="col-xs-5">
            <div class="row">
                <input type="text" class="form-control {{ $option['class'] }}" id="{{ $option['name']."-".$layerId }}" name="{{ $option['name'] }}" placeholder="{{ $option['placeholder'] }}" value="{{ $optionName }}">
            </div>
        </div>
    </div>
@endif