<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ url('/admin') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/common/images/logo_admin_mini.png') }}" alt="" height="40">
                    </span>
            <span class="logo-lg">
                        <img src="{{ asset('assets/common/images/logo_admin.png') }}" alt="" height="40">
                    </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ url('/admin') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('assets/common/images/logo_admin_mini.png') }}" alt="" height="40">
                    </span>
            <span class="logo-lg">
                        <img src="{{ asset('assets/common/images/logo_admin.png') }}" alt="" height="40">
                    </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == '') ? 'active' : '' }}" href="{{ url('/admin') }}">
                        <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>


                <li class="menu-title"><span data-key="t-menu">Academy</span></li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPlayers" data-bs-toggle="collapse" role="button" aria-expanded="{{ (request()->segment(2) == 'players') ? 'true' : 'false' }}" aria-controls="sidebarPlayers">
                        <i class="mdi mdi-gift"></i> <span data-key="t-raffles-main">Players</span>
                    </a>
                    <div class="collapse menu-dropdown {{ (request()->segment(2) == 'players') ? 'show' : '' }}" id="sidebarPlayers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('/admin/players') }}" class="nav-link {{ (request()->segment(2) == 'players' && request()->segment(3) == '') ? 'active' : '' }}" data-key="t-players">All Players</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/admin/players/create') }}" class="nav-link {{ (request()->segment(2) == 'players' && request()->segment(3) == 'create') ? 'active' : '' }}" data-key="t-players-add">Add New</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarEvents" data-bs-toggle="collapse" role="button" aria-expanded="{{ (request()->segment(2) == 'events') ? 'true' : 'false' }}" aria-controls="sidebarEvents">
                        <i class="mdi mdi-gift"></i> <span data-key="t-raffles-main">Events</span>
                    </a>
                    <div class="collapse menu-dropdown {{ (request()->segment(2) == 'events') ? 'show' : '' }}" id="sidebarEvents">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('/admin/events') }}" class="nav-link {{ (request()->segment(2) == 'events' && request()->segment(3) == '') ? 'active' : '' }}" data-key="t-events">All Events</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/admin/events/create') }}" class="nav-link {{ (request()->segment(2) == 'events' && request()->segment(3) == 'create') ? 'active' : '' }}" data-key="t-events-add">Add New</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'attendances') ? 'active' : '' }}" href="{{ url('/admin/attendances') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-attendances">Attendances</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'payments') ? 'active' : '' }}" href="{{ url('/admin/payments') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-payments">Payments</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'join-requests') ? 'active' : '' }}" href="{{ url('/admin/join-requests') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-join-requests">Join Requests</span>
                    </a>
                </li>


                <li class="menu-title"><span data-key="t-system">Settings</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'batting-styles') ? 'active' : '' }}" href="{{ url('/admin/batting-styles') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-batting-styles">Batting Styles</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'bowling-styles') ? 'active' : '' }}" href="{{ url('/admin/bowling-styles') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-bowling-styles">Bowling Styles</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'internal-teams') ? 'active' : '' }}" href="{{ url('/admin/internal-teams') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-internal-teams">Internal Teams</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'payment-statuses') ? 'active' : '' }}" href="{{ url('/admin/payment-statuses') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-payment-statuses">Payment Statuses</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'player-levels') ? 'active' : '' }}" href="{{ url('/admin/player-levels') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-player-levels">Player Levels</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'player-roles') ? 'active' : '' }}" href="{{ url('/admin/player-roles') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-player-roles">Player Roles</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'player-statuses') ? 'active' : '' }}" href="{{ url('/admin/player-statuses') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-player-statuses">Player Statuses</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'schools') ? 'active' : '' }}" href="{{ url('/admin/schools') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-schools">Schools</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'users') ? 'active' : '' }}" href="{{ url('/admin/users') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-users">Users</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'user-roles') ? 'active' : '' }}" href="{{ url('/admin/user-roles') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-user-roles">User Roles</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ (request()->segment(2) == 'venues') ? 'active' : '' }}" href="{{ url('/admin/venues') }}">
                        <i class="mdi mdi-account-details"></i> <span data-key="t-venues">Venues</span>
                    </a>
                </li>



            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
