@extends('admin.layouts.admin')


@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Users
        <small>Create a new user</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Administration</a></li>
        <li><a href="{{ route('admin.user.index') }}">Users</a></li>
        <li class="active">Create</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Page Content -->
    @include('admin.components.form-alerts')

    <div class="row">
        <div class="col-md-7">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Add new user</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ route('admin.user.store') }}">
                    {{ csrf_field() }}

                    <div class="box-body">

                        @if($errors->has("name")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                                @if ($errors->has("name"))
                                    <p class="help-block">
                                        {{ $errors->first("name") }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        @if($errors->has("email")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                                @if ($errors->has("email"))
                                    <p class="help-block">
                                        {{ $errors->first("email") }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        @if($errors->has("roles")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="roles" class="col-sm-2 control-label">Roles</label>
                            <div class="col-sm-10">
                                <?php
                                    $oldSelect = "";
                                    if(!empty(old('roles'))){
                                        $old = old('roles');
                                        $falttened = array_flatten($old);
                                        $oldSelect = implode(",",$falttened);
                                    }
                                ?>
                                <select id="roles" name="roles[][id]" class="form-control select2" multiple="multiple" data-placeholder="Select a Role" data-old="{{ $oldSelect }}">
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ Str::title($role->name) }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has("roles"))
                                    <p class="help-block">
                                        {{ $errors->first("roles") }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        @if($errors->has("password")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="password" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="{{ old('password') }}">
                                @if ($errors->has("password"))
                                    <p class="help-block">
                                        {{ $errors->first("password") }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        @if($errors->has("password_confirmation")) <div class="form-group has-error"> @else <div class="form-group"> @endif
                            <label for="password_confirmation" class="col-sm-2 control-label">Confirm</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Retype your password" value="{{ old('password_confirmation') }}">
                                @if ($errors->has("password_confirmation"))
                                    <p class="help-block">
                                        {{ $errors->first("password_confirmation") }}
                                    </p>
                                @endif
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{ route('admin.user.index') }}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-success pull-right">Create</button>
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