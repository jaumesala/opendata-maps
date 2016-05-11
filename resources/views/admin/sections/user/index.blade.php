@extends('admin.layouts.admin')


@section('content')

@include('admin.components.form-confirmations')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Users
        <small>Manage your users</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard.index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Administration</a></li>
        <li class="active">Users</li>
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
                    <h3 class="box-title">System users</h3>
                    <div class="box-tools">
                        @permission('create-user')
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <a class="btn btn-success pull-right" href="{{ route('admin.user.create') }}"><i class="fa fa-fw fa-user-plus"></i> Add user</a>
                        </div>
                        @endpermission
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>email</th>
                                <th>Roles</th>
                                <th class="text-right">Maps</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td><a href="mailto:{{ $user->email }}?subject=%5BOpendataMaps%5D%20">{{ $user->email }}</a></td>
                                <td>
                                    @foreach($user->roles as $role)
                                    <a href="#" class="label label-primary">{{ Str::title($role->name) }}</a>
                                    @endforeach
                                </td>
                                <td class="text-right">{{ $user->maps->count() }}</td>
                                <td class="text-right">
                                    @permission('edit-user')
                                    <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                    @endpermission
                                    @permission('destroy-user')
                                    <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#confirmDelete" data-id="{{ $user->id }}" data-action="{{ route('admin.user.destroy', $user->id) }}"><i class="fa fa-trash"></i> Delete</button>
                                    @endpermission
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