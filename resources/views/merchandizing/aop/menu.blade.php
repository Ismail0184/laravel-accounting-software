<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse" id="topbar-collapse">
    <ul class="nav navbar-nav">
        <li><a class="home" href="{{ url('dashboard') }}"><i class='fa fa-home'></i> <span>Home</span></a></li>
        <li><a href="{{ url('dashboard') }}"><i class='fa fa-home'></i> <span>Merchandising</span> <span class="caret"></span></a></li>
        <li><a href="{{ url('dashboard') }}"><i class='fa fa-home'></i> <span>Inventory</span> <span class="caret"></span></a></li>
        <li><a href="{{ url('dashboard') }}"><i class='fa fa-home'></i> <span>Production</span> <span class="caret"></span></a></li>
        <li><a href="{{ url('dashboard') }}"><i class='fa fa-home'></i> <span>Planning</span> <span class="caret"></span></a></li>
        <li><a href="{{ url('dashboard') }}"><i class='fa fa-home'></i> <span>Knitting</span> <span class="caret"></span></a></li>
        <li><a href="{{ url('dashboard') }}"><i class='fa fa-home'></i> <span>Dyeing</span> <span class="caret"></span></a></li>
        <li><a href="{{ url('dashboard') }}"><i class='fa fa-home'></i> <span>Commercial</span> <span class="caret"></span></a></li>
                    
        
        <li class="dropdown right-sub">
            <a tabindex="0" data-toggle="dropdown"><i class='fa fa-calculator'></i> Account <span class="caret"></span></a>
            
            <!-- role="menu": fix moved by arrows (Bootstrap dropdown) -->
            <ul class="dropdown-menu" role="menu">
                <li class="dropdown-submenu">
                    <a tabindex="0" data-toggle="dropdown">Action</a>
                    
                    <ul class="dropdown-menu">
                        <li><a tabindex="0">Sub action</a></li>
                        <li class="dropdown-submenu">
                            <a tabindex="0" data-toggle="dropdown">Another sub action</a>
                            
                            <ul class="dropdown-menu">
                                <li><a tabindex="0">Sub action</a></li>
                                <li><a tabindex="0">Another sub action</a></li>
                                <li><a tabindex="0">Something else here</a></li>
                            </ul>
                        </li>
                        <li><a tabindex="0">Something else here</a></li>
                    </ul>
                </li>
                <li><a tabindex="0">Another action</a></li>
                <li class="dropdown-submenu">
                    <a tabindex="0" data-toggle="dropdown">Something else here</a>
                    
                    <ul class="dropdown-menu">
                        <li><a tabindex="0">Sub action</a></li>
                        <li><a tabindex="0">Another sub action</a></li>
                        <li><a tabindex="0">Something else here</a></li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li><a tabindex="0">Separated link</a></li>
            </ul>
        </li>
        
        @if (Entrust::can(['manage_users', 'manage_roles', 'manage_permissions', 'role_permission']))
        <li class="dropdown right-sub">
            <a tabindex="0" data-toggle="dropdown"><i class='fa fa-user-secret'></i> <span>Users</span> <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                @if (Entrust::can(['manage_users', 'create_users', 'update_users', 'delete_users']))
                <li><a href="{{ url('users') }}"><i class='fa fa-users'></i> <span>Users</span></a></li>
                @endif
                @if (Entrust::can('manage_roles'))
                <li><a href="{{ url('roles') }}"><i class='fa fa-cogs'></i> <span>Roles</span></a></li>
                @endif
                @if (Entrust::can('manage_permissions'))
                <li><a href="{{ url('permissions') }}"><i class='fa fa-key'></i> <span>Permissions</span></a></li>
                @endif
                @if (Entrust::can('role_permission'))
                <li><a href="{{ url('role_permission') }}"><i class='fa fa-user-plus'></i> <span>Roles &amp; Permissions</span></a></li>
                @endif
            </ul>
        </li>
        @endif 
        
    </ul>                     
</div><!-- /.navbar-collapse -->
