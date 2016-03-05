@extends('admin.layouts.admin')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Settings
        <small>Control Panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Administration</a></li>
        <li class="active">Settings</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Page Content -->
    @include('admin.components.form-alerts')

    <div class="row">

        <div class="col-md-7">

            @foreach($settings as $group => $settingsGroup)
            <!-- box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ Str::title($group) }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.settings.update') }}">
                    <input name="_method" type="hidden" value="PUT">
                    {{ csrf_field() }}
                    <input type="hidden" name="group" value="{{ $group }}">

                    <div class="box-body">

                    @foreach($settingsGroup as $setting)
                        @if($errors->has("settings.$setting->id.value")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="{{ $setting->key }}" class="col-sm-2 control-label">{{ Str::title($setting->key ) }}</label>

                            <div class="col-sm-10">
                                <input type="hidden" name="{{ "settings[$setting->id][key]" }}" value="{{ $setting->key }}">
                                <input  type="text"
                                        class="form-control"
                                        id="{{ $setting->key }}"
                                        name="{{ "settings[$setting->id][value]" }}"
                                        placeholder="{{ Str::title( $setting->key ) }}"
                                        value="{{ $setting->value }}">

                                @if ($errors->has("settings.$setting->id.value"))
                                    <p class="help-block">
                                        {{ $errors->first("settings.$setting->id.value") }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach


                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-primary pull-right">Save</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
            @endforeach

        </div>
        <!-- /.col -->
        <div class="col-md-5">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Add new setting</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.setting.store') }}">
                    {{ csrf_field() }}

                    <div class="box-body">

                        @if($errors->has("group")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="group" class="col-sm-2 control-label">Group</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="group" name="group" placeholder="group" value="{{ old('group') }}">
                                @if ($errors->has("group"))
                                    <p class="help-block">
                                        {{ $errors->first("group") }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        @if($errors->has("key")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="key" class="col-sm-2 control-label">Key</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="key" name="key" placeholder="Key" value="{{ old('key') }}">
                                @if ($errors->has("key"))
                                    <p class="help-block">
                                        {{ $errors->first("key") }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        @if($errors->has("value")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="value" class="col-sm-2 control-label">Value</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="value" name="value" placeholder="Value" value="{{ old('value') }}">
                                @if ($errors->has("value"))
                                    <p class="help-block">
                                        {{ $errors->first("value") }}
                                    </p>
                                @endif
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="http://schiedam-map.app/admin/settings" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-success pull-right">Add</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->

            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Delete a setting</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.setting.destroy', 0) }}">
                    <input name="_method" type="hidden" value="DELETE">
                    {{ csrf_field() }}

                    <div class="box-body">

                        @if($errors->has("id")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="id" class="col-sm-2 control-label">Setting</label>
                            <div class="col-sm-10">
                                <select name="id" id="id" class="form-control">
                                    <option disabled selected>Select a setting</option>
                                    @foreach($settings as $group => $settingsGroup)
                                        <optgroup label="{{ $group }}">
                                            @foreach($settingsGroup as $setting)
                                                <option value="{{ $setting->id }}">{{ $setting->key }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @if ($errors->has("id"))
                                    <p class="help-block">
                                        {{ $errors->first("id") }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                @if($errors->has("confirmation")) <div class="has-error"> @else <div> @endif
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="confirmation"> Confirm delete
                                        </label>
                                        @if ($errors->has("confirmation"))
                                            <p class="help-block">
                                                {{ $errors->first("confirmation") }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="http://schiedam-map.app/admin/settings" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-danger pull-right">Delete</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->

        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

</section>
<!-- /.content -->

@stop