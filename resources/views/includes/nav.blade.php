<nav class="navbar navbar-expand  static-top">
    <a class="hamburger" href="#" id="sidebarToggle"><i class="fas fa-bars"></i></a>
    <a class="_logo" href="index.html">E-bob Admin</a>
    <ul class="navbar-nav ml-auto top_nav">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{-- <img src="{{ Auth::user()->picture }}" class="user_log" alt="" /> --}}
                {{-- <span>{{ Auth::user()->name }}</span> --}}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                {{-- <span class="dropdown-item usernamelab">{{ Auth::user()->name }}</span> --}}
                <a class="dropdown-item" href="#"><i class="fa fa-user"> </i> Profile</a>
                <a class="dropdown-item" href="#"><i class="fa fa-cogs"> </i> Settings</a>
                <a class="dropdown-item" href="#"><i class="fa fa-power-off"> </i> Logout</a>
            </div>
        </li>
    </ul>
</nav>