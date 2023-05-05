<!DOCTYPE html>
<html lang="en">
    <head>

		@include('manage.layouts.head')
		@yield('page-css')

	</head>
	<body>
        <div class="main-wrapper">
            <div class="header">
                <div class="header-left">
                    <a href="index.html" class="logo">
                        <img src="{{asset_admin('img/logo.png')}}" alt="Platinum" width="40" height="40">
                    </a>
                </div>
                <a id="toggle_btn" href="javascript:void(0);">
                    <span class="bar-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </a>
                <div class="page-title-box">
                    <h3>{{ config('constants.company') }}</h3>
                </div>
                <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
                <ul class="nav user-menu">
                    <li class="nav-item dropdown has-arrow main-drop">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img src="{{ $globaldata['admin']->imagefilepath }}" alt="{{ $globaldata['admin']->firstname }}">
                        </span>
                        <span>{{ $globaldata['admin']->firstname }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ url_admin('profile') }}">My Profile</a>
                            <a class="dropdown-item" href="{{ url_admin('logout') }}">Logout</a>
                        </div>
                    </li>
                </ul>
                <div class="dropdown mobile-user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ url_admin('profile') }}">My Profile</a>
                            <a class="dropdown-item" href="{{ url_admin('logout') }}">Logout</a>
                    </div>
                </div>
            </div>
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
                    <div id="sidebar-menu" class="sidebar-menu">

                    <!-- Menu -->
                    @include('manage.layouts.leftmenu')
                    <!-- Menu -->
                    </div>
                </div>
            </div>
            <div class="page-wrapper">
                <div class="content container-fluid">

            	@yield('content')

            </div>
            </div>
        </div>

        @include('manage.layouts.foot')
		@yield('page-scripts')
        
    </body>
</html>

