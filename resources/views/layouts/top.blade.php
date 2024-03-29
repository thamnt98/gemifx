<header class="header">
    <div class="logo-container">
        <a href="{{ route('home') }}" class="logo">
        <img src="{{ asset('image/logo.png') }}" height="35" alt="Porto Admin" />
        </a>
        <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>
    <!-- start: search & user box -->
    <div class="header-right">
        <div id="userbox" class="userbox">
            <a href="#" data-toggle="dropdown">
                <figure class="profile-picture">
                <img src="{{ asset('image/!logged-user.jpg') }}" alt="Joseph Doe" class="img-circle" data-lock-picture="assets/images/!logged-user.jpg" />
                </figure>
                <div class="profile-info" style="margin: 0px" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                <span class="name"><?php echo(Auth::user()->full_name)?> </span>
                </div>
                @if(Auth::user()->check_active == 1)
                    <figure class="profile-picture">
                        <img src="{{ asset('image/tick.png') }}" alt="Joseph Doe" class="img-circle" data-lock-picture="assets/images/!logged-user.jpg" />
                    </figure>
                @endif
                <i class="fa custom-caret"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled">
                    <li class="divider"></li>
                    <li>
                    <a role="menuitem" tabindex="-1" href="{{ route('account.detail') }}"><i class="fa fa-user"></i> My Profile</a>
                    </li>
                    <li>
                    <a role="menuitem" tabindex="-1" href="{{ route('logout') }}"><i class="fa fa-power-off"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>
