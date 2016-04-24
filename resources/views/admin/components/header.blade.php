<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ route('admin.dashboard.index') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>S</b>M</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Schiedam</b>Maps</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        @if(File::isFile('img/admin/users/'.Auth::user()->id.'-avatar.png'))
                            <img src="{{ asset('img/admin/users/'.Auth::user()->id.'-avatar.png') }}" class="user-image" alt="{{ Auth::user()->name }}">
                        @else
                            <img src="{{ asset('img/admin/users/default.jpg') }}" class="user-image" alt="{{ Auth::user()->name }}">
                        @endif
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            @if(File::isFile('img/admin/users/'.Auth::user()->id.'-avatar.png'))
                                <img src="{{ asset('img/admin/users/'.Auth::user()->id.'-avatar.png') }}" class="img-circle" alt="{{ Auth::user()->name }}">
                            @else
                                <img src="{{ asset('img/admin/users/default.jpg') }}" class="img-circle" alt="{{ Auth::user()->name }}">
                            @endif

                            <p>
                                {{ Auth::user()->name }} - Admin
                                <?php
                                    $createdAt  = Auth::user()->created_at;
                                    $date       = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt);
                                ?>
                                <small>Member since {{ $date->year }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <!-- <a href="#" class="btn btn-default btn-flat">Profile</a> -->
                            </div>
                            <div class="pull-right">
                                <a href="{{ url('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                {{--
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
                --}}
            </ul>
        </div>
    </nav>
</header>