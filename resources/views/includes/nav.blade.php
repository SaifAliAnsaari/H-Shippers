<nav class="navbar navbar-expand  static-top">
    <a class="hamburger" href="#" id="sidebarToggle"><i class="fas fa-bars"></i></a>
    <a class="_logo" href="/"><img src="/images/h-shippers.svg" alt="" /></a>

    <ul class="navbar-nav ml-auto top_nav">
        <li class="nav-item TM_icon">
            <a class="nav-link" href="#"><img src="/images/q-link-icon.svg" alt="" /></a>
        </li>
        <li class="nav-item TM_icon">
            <a class="nav-link" href="#"><img src="/images/settings-icon.svg" alt="" /></a>
        </li>
        <li class="nav-item TM_icon">
            <a class="nav-link" href="#">
                <span class="badge">5</span>
                <img src="/images/bell-icon.svg" alt="" /></a>
        </li>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img src="{{ Auth::user()->picture }}" class="user_log" alt="" />
                <span>{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <span class="dropdown-item usernamelab">{{ Auth::user()->name }}</span>
                <a class="dropdown-item" href="user-profile.html"><i class="fa fa-user"> </i> Profile</a>
                <a class="dropdown-item" href="user-profile.html"><i class="fa fa-cogs"> </i> Settings</a>
                <a class="dropdown-item" href="/logout"><i class="fa fa-power-off"> </i> Logout</a>
            </div>
        </li>
    </ul>

</nav>
