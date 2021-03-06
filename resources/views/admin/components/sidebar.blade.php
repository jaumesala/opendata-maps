<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                @if(File::isFile('img/admin/users/'.Auth::user()->id.'-avatar.png'))
                    <img src="{{ asset('img/admin/users/'.Auth::user()->id.'-avatar.png') }}" class="img-circle" alt="{{ Auth::user()->name }}" width="45" height="45">
                @else
                    <img src="{{ asset('img/admin/users/default.jpg') }}" class="img-circle" alt="{{ Auth::user()->name }}" width="45" height="45">
                @endif
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        {{--
        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        --}}

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <!-- Optionally, you can add icons to the links -->
            <li @if(Request::is('admin')) class="active" @endif>
                <a href="{{ route('admin.dashboard.index') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <?php
                if( Request::is('admin/settings*') || Request::is('admin/user*') || Request::is('admin/role*') || Request::is('admin/permission*')){
                    $adminActive = "active";
                } else {
                    $adminActive = "";
                }
            ?>
            <li class="treeview {{ $adminActive }}">
                <a href="#">
                    <i class="fa fa-cog"></i> <span>Administration</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @permission('list-settings')
                    <li @if(Request::is('admin/settings*')) class="active" @endif>
                        <a href="{{ route('admin.settings.index') }}"><i class="fa fa-circle-o"></i> Settings</a>
                    </li>
                    @endpermission
                    @permission('list-users')
                    <li @if(Request::is('admin/user*')) class="active" @endif>
                        <a href="{{ route('admin.user.index') }}"><i class="fa fa-circle-o"></i> Users</a>
                    </li>
                    @endpermission
                    @permission('list-roles')
                    <li @if(Request::is('admin/role*')) class="active" @endif>
                        <a href="{{ route('admin.role.index') }}"><i class="fa fa-circle-o"></i> Roles</a>
                    </li>
                    @endpermission
                    @permission('list-permissions')
                    <li @if(Request::is('admin/permission*')) class="active" @endif>
                        <a href="{{ route('admin.permission.index') }}"><i class="fa fa-circle-o"></i> Permissions</a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @permission('list-sources')
            <li @if(Request::is('admin/source*')) class="active" @endif>
                <a href="{{ route('admin.source.index') }}">
                    <i class="fa fa-database"></i> <span>Sources</span>
                </a>
            </li>
            @endpermission
            @permission('list-maps')
            <li @if(Request::is('admin/map*')) class="active" @endif>
                <a href="{{ route('admin.map.index') }}">
                    <i class="fa fa-map"></i> <span>Maps</span>
                </a>
            </li>
            @endpermission
            {{--
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-link"></i> <span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#">Link in level 2</a></li>
                    <li><a href="#">Link in level 2</a></li>
                </ul>
            </li>
            --}}
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>