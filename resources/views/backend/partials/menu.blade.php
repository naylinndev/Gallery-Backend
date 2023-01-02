<div class="site-menubar">
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu" data-plugin="menu">
                    <li class="site-menu-category">
                        General
                    </li>
                    <li class="site-menu-item" id="nav-dashboard">
                        <a class="animsition-link waves-effect waves-classic" href="{{ url('dashboard') }}">
                            <i aria-hidden="true" class="site-menu-icon md-view-dashboard">
                            </i>
                            <span class="site-menu-title">
                                Dashboard
                            </span>
                            <span class="site-menu-arrow">
                            </span>
                        </a>
                    </li>

                    <li class="site-menu-item " id="nav-category">
                        <a class="waves-effect waves-classic waves-effect waves-classic" href="{{ url('category') }}">
                            <i aria-hidden="false" class="site-menu-icon fa-mobile">
                            </i>
                            <span class="site-menu-title">
                                Category
                            </span>
                            <span class="site-menu-arrow">
                            </span>
                        </a>
                    </li>

                    <li class="site-menu-item " id="nav-photo">
                        <a class="waves-effect waves-classic waves-effect waves-classic" href="{{ url('photo') }}">
                            <i aria-hidden="false" class="site-menu-icon fa-mobile">
                            </i>
                            <span class="site-menu-title">
                                Photos
                            </span>
                            <span class="site-menu-arrow">
                            </span>
                        </a>
                    </li>



                    @if(Auth::user()->isAdmin())
                    <li class="site-menu-item " id="nav-users">
                        <a class="waves-effect waves-classic waves-effect waves-classic" href="{{ url('admin') }}">
                            <i aria-hidden="false" class="site-menu-icon wb-users">
                            </i>
                            <span class="site-menu-title">
                                Users
                            </span>
                            <span class="site-menu-arrow">
                            </span>
                        </a>
                    </li>
                   
                    @endif

                   



                </ul>
            </div>
        </div>
    </div>
    <div class="site-menubar-footer">
        <a class="fold-show" data-original-title="User Account" data-placement="top" data-toggle="tooltip" href="javascript: void(0);">
            <span aria-hidden="true" class="icon md-key">
            </span>
        </a>
        <a data-original-title="Lock" data-placement="top" data-toggle="tooltip" href="javascript: void(0);">
            <span aria-hidden="true" class="icon md-eye-off">
            </span>
        </a>
        <a data-original-title="Logout" data-placement="top" data-toggle="tooltip" href="{{url('auth/logout')}}">
            <span aria-hidden="true" class="icon md-power">
            </span>
        </a>
    </div>
</div>
