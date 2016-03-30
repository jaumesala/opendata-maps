@extends('admin.layouts.admin')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Roles
        <small>Edit role information</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Administration</a></li>
        <li><a href="{{ route('admin.role.index') }}">Roles</a></li>
        <li class="active">Edit</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Page Content -->
    @include('admin.components.form-alerts')

    <div class="row">
        <div class="col-md-7">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit role information</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.role.update', $role->id) }}">
                    <input name="_method" type="hidden" value="PUT">
                    {{ csrf_field() }}

                    <div class="box-body">

                        @if($errors->has("name")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name', $role->name) }}">
                                @if ($errors->has("name"))
                                    <p class="help-block">
                                        {{ $errors->first("name") }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        @if($errors->has("label")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="label" class="col-sm-2 control-label">Label</label>
                            <div class="col-sm-10">
                                <input type="label" class="form-control" id="label" name="label" placeholder="label" value="{{ old('label', $role->label) }}">
                                @if ($errors->has("label"))
                                    <p class="help-block">
                                        {{ $errors->first("label") }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        @if($errors->has("permissions")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="permissions" class="col-sm-2 control-label">Permissions</label>
                            <div class="col-sm-10">
                                <?php
                                    $oldSelect = $role->permissions->implode('id',',');
                                    if(!empty(old('permissions'))){
                                        $old = old('permissions');
                                        $falttened = array_flatten($old);
                                        $oldSelect = implode(",",$falttened);
                                    }
                                ?>
                                <select id="permissions" name="permissions[][id]" class="form-control select2" multiple="multiple" data-placeholder="Select a Role" data-old="{{ $oldSelect }}">
                                    @foreach($permissions as $role)
                                    <option value="{{ $role->id }}">{{ Str::title($role->label) }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has("permissions"))
                                    <p class="help-block">
                                        {{ $errors->first("permissions") }}
                                    </p>
                                @endif
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{ route('admin.role.index') }}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-primary pull-right">Update</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>


</section>
<!-- /.content -->

@stop