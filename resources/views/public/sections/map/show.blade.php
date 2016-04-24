@extends('public.layouts.base')

@section('content')

@include('admin.components.share-modal')

<div id="map-view"></div>

<button type="button" id="button-info" class="btn btn-primary"><i class="fa fa-info-circle" aria-hidden="true"></i></button>

<div id="map-info">
    <div class="box box-widget widget-user-2">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-yellow">
            <h3 class="widget-user-username">{{ $map->name }}</h3>
        </div>
        <div class="box-body">
            <div class="body-description">
                <strong><i class="fa fa-info-circle margin-r-5"></i> Description</strong>
                <p class="text-muted">
                    {{ $map->description }}
                </p>
            </div>
            <div class="body-creator hidden-xs">
                <hr>
                <strong><i class="fa fa-user margin-r-5"></i> Creator</strong>
                <?php
                    $createdAt  = $map->created_at;
                    $date       = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt);
                ?>
                <p class="text-muted">By {{ $map->user->name }}, {{ $date->diffForHumans() }}</p>
            </div>
            <div class="body-tags hidden-xs">
                <hr>
                <strong><i class="fa fa-tags margin-r-5"></i> Tags</strong>

                <p>
                    @foreach($map->tags as $tag)
                        <span class="label label-default">{{ $tag->name }}</span>
                    @endforeach
                </p>
            </div>
            <div class="body-layers">
                <hr>
                <strong><i class="fa fa-bars margin-r-5"></i> layers</strong>

                <ul class="list-unstyled layers-list">
                    @foreach($map->layers as $layer)
                    <li>
                        {{ $layer->name }}

                        <span class="label label-default pull-right">{{ $layer->type }}</span>
                        {{--
                        @if($layer->visible)
                            <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-eye-slash"></i></a>
                            <a href="#" class="btn btn-default btn-xs pull-right hidden"><i class="fa fa-eye"></i></a>
                        @else
                            <a href="#" class="btn btn-default btn-xs pull-right hidden"><i class="fa fa-eye-slash"></i></a>
                            <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-eye"></i></a>
                        @endif
                        --}}
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer text-center">
                <button class="btn btn-success pull-left" data-toggle="modal" data-target="#shareModal"><i class="fa fa-fw fa-share-alt"></i> Share</button>
                <button id="close-panel" class="btn btn-default pull-right"><i class="fa fa-fw fa-times-circle"></i> Close</button>

            </div>
        </div>
    </div> <!-- /.box-widget -->
</div>


@push('preAppScripts')
    <script>
        var map = {!! json_encode($map) !!}
    </script>
@endpush


@stop