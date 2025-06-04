<nav
    class="px-4 main-header d-flex justify-content-between align-items-center navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <ul class="navbar-nav d-flex align-items-center">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" role="button">
                <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-menu">
                <a role="button" href="{{ route('profile.edit') }}" class="mb-3 dropdown-item" id="btn-submit">
                    <i class="fas fa-user-cog"></i></i> Akun
                </a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="dropdown-item">
                        <i class="fas fa-sign-out-alt" id="btn-submit"></i> Keluar
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
