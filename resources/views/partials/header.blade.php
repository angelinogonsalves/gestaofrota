<nav class="main-header navbar navbar-expand navbar-white navbar-light" aria-label="" aria-labelledby="">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/') }}" class="nav-link">Início</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <span class="badge badge-primary">
                    {{ auth()->user()->nome }} -
                </span>
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a href="" class="dropdown-item">
                    <i class="fas fa-envelope"> </i> Email: {{ auth()->user()->email }}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ url('logout/') }}" class="badge badge dropdown-item">
                    <button type="button"  class="btn btn-danger btn-sm">
                        <i class="fas fa-power-off"></i> Sair do sistema
                    </button>
                </a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>