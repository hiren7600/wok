<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{!! (isset($menu_dashboard) && $menu_dashboard) ? 'active' : '' !!}">
                    <a href="{{ url_admin('dashboard') }}">
                        <i class="la la-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if(isset(auth('admin')->user()->user_id))
                <li class="{!! (isset($menu_designations) && $menu_designations) ? 'active' : '' !!}">
                    <a href="{{ url_admin('designations') }}">
                        <i class="la la-user"></i>
                        <span>Designations</span>
                    </a>
                </li>
                <li class="{!! (isset($menu_users) && $menu_users) ? 'active' : '' !!}">
                    <a href="{{ url_admin('users') }}">
                        <i class="la la-user"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="{!! (isset($menu_categories) && $menu_categories) ? 'active' : '' !!}">
                    <a href="{{ url_admin('categories') }}">
                        <i class="la la-user"></i>
                        <span>Categories</span>
                    </a>
                </li>
                @endif
                <li class="{!! (isset($menu_projects) && $menu_projects) ? 'active' : '' !!}">
                    <a href="{{ url_admin('projects') }}">
                        <i class="la la-user"></i>
                        <span>Projects</span>
                    </a>
                </li>
                <li class="{!! (isset($menu_client) && $menu_client) ? 'active' : '' !!}">
                    <a href="{{ url_admin('clients') }}">
                        <i class="la la-user"></i>
                        <span>Clients</span>
                    </a>
                </li>
                <li class="{!! (isset($menu_media) && $menu_media) ? 'active' : '' !!}">
                    <a href="{{ url_admin('project-media') }}">
                        <i class="la la-user"></i>
                        <span>Media</span>
                    </a>
                </li>
                <li class="{!! (isset($menu_tasks) && $menu_tasks) ? 'active' : '' !!}">
                    <a href="{{ url_admin('tasks') }}">
                        <i class="la la-user"></i>
                        <span>Tasks</span>
                    </a>
                </li>


            </ul>
        </div>
    </div>
</div>
