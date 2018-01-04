<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
        </li>
    </ul>
    <ul class="nav navbar-nav ml-auto">

        <li class="nav-item dropdown">

            <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img src="/img/avatars/6.jpg" class="img-avatar" alt="First Line Client">
            </a>

            <div class="dropdown-menu dropdown-menu-right">

                <div class="dropdown-header text-center">
                    <strong>Admin Account</strong>
                </div>

                <a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="fa fa-user"></i>Profile</a>
                <div class="divider"></div>
                <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i> Logout</a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>

        </li>
    </ul>
    <button class="navbar-toggler " type="button">
        <span class="navbar-toggler-icon"></span>
    </button>

</header>