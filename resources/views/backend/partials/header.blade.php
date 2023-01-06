<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">
    <div class="navbar-header">
        <button class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided" data-toggle="menubar" type="button">
            <span class="sr-only">
                Toggle navigation
            </span>
            <span class="hamburger-bar">
            </span>
        </button>
        <button class="navbar-toggler collapsed" data-target="#site-navbar-collapse" data-toggle="collapse" type="button">
            <i aria-hidden="true" class="icon wb-more-horizontal" style="color: #757575 !important;">
            </i>
        </button>
        <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
            <img class="navbar-brand-logo" src="{{url('images/ic_logo.png')}}">
                <span class="navbar-brand-text hidden-xs-down">
                    Gallery
                </span>
            </img>
        </div>
    </div>
    <div class="navbar-container container-fluid">
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
            <!-- Navbar Toolbar -->
            <ul class="nav navbar-toolbar">
                <li class="nav-item hidden-float" id="toggleMenubar">
                    <a class="nav-link" data-toggle="menubar" href="#" id="toggleMenu" role="button">
                        <i class="icon hamburger hamburger-arrow-left">
                            <span class="sr-only">
                                Toggle menubar
                            </span>
                            <span class="hamburger-bar">
                            </span>
                        </i>
                    </a>
                </li>
                <li class="nav-item hidden-sm-down" id="toggleFullscreen">
                    <a class="nav-link icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
                        <span class="sr-only">
                            Toggle fullscreen
                        </span>
                    </a>
                </li>
                <li class="nav-item hidden-sm-down">
                    <div class="digital-clock"></div>
                </li>
            </ul>
        </div>
        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">

            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" title="Messages"
                  aria-expanded="false" data-animation="scale-up" role="button">
                  <i class="icon wb-envelope" aria-hidden="true"></i>
                  <span class="badge badge-pill badge-info up" id="message_count">0</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                  <div class="dropdown-menu-header">
                    <h5>MESSAGES</h5>
                    <span class="badge badge-round badge-info" id="message_count_title">-</span>
                  </div>

                  <div class="list-group">
                    <div data-role="container" id="message_container">
                      <div data-role="content" id="message_content">

                      </div>
                    </div>
                  </div>
                  <div class="dropdown-menu-footer">
                    <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                      <i class="icon wb-settings" aria-hidden="true"></i>
                    </a>
                    <a class="dropdown-item" href="{{ url('message') }}" role="menuitem">
                      See all messages
                    </a>
                  </div>
                </div>
              </li>



            <li class="nav-item dropdown">
                <a aria-expanded="false" class="nav-link navbar-avatar" data-animation="scale-up" data-toggle="dropdown" href="#" role="button">
                    <span class="avatar avatar-online">
                        <img alt="..." src="{{url('images/user.png')}}">
                            <i>
                            </i>
                        </img>
                    </span>
                </a>
                <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="javascript:void(0)" role="menuitem" id="change-password">
                        <i aria-hidden="true" class="icon wb-lock">
                        </i>
                        Change Password
                    </a>
                    <div class="dropdown-divider" role="presentation">
                    </div>
                    <a class="dropdown-item" href="{{url('auth/logout')}}" role="menuitem">
                        <i aria-hidden="true" class="icon wb-power">
                        </i>
                        Logout
                    </a>
                </div>
            </li>


        </ul>

    </div>
</nav>
