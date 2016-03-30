@extends('admin.layouts.admin')


@section('content')

@include('admin.components.form-confirmations')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Roles
        <small>Manage your roles</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Administration</a></li>
        <li class="active">Roles</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- Page Content -->
    @include('admin.components.form-alerts')

    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">System roles</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <a class="btn btn-success pull-right" href="{{ route('admin.role.create') }}"><i class="fa fa-fw fa-plus"></i> Add role</a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Label</th>
                                <th class="permissions">Permissions</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->label }}</td>
                                <td>
                                    @foreach($role->permissions as $permission)
                                    <a href="#" class="label label-primary">{{ Str::title($permission->label) }}</a>
                                    @endforeach
                                </td>
                                <td class="text-right">
                                    <!-- <div class="btn-group"> -->
                                        <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                        <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#confirmDelete" data-id="{{ $role->id }}" data-action="{{ route('admin.role.destroy', $role->id) }}"><i class="fa fa-trash"></i> Delete</button>
                                    <!-- </div> -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

</section>
<!-- /.content -->

@stop