<nav class="px-4 main-header d-flex justify-content-between navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <ul class="navbar-nav">
        <li class="nav-item" role="button">
            <i class="fas fa-sign-out-alt" id="btn-submit"></i>
        </li>
    </ul>
</nav>

<form id="form-logout" action="{{ route('logout') }}" method="post">
    @csrf
</form>
