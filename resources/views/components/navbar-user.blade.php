<nav class="navbar custom-nav">
    <div class="container-fluid d-flex">
        <!-- Logo di kiri -->
        <a class="navbar-brand" href="#">
            <img src="{{ asset('assets/img/logo/logoapjifix.png') }}" alt="Logo">
        </a>
        <div class="dropdown profile-dropdown ms-auto">
            <a class="btn btn-light dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class='bx bx-user-circle fs-4'></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li class="profile-header">
                    <i class='bx bx-user-circle profile-icon'></i>
                    <div class="profile-info">
                        <p>Bima</p>
                        <small>Anggota Account</small>
                    </div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="#">
                        <i class='bx bx-user'></i> Profile
                    </a>
                </li>
                {{-- <li>
                    <form class="dropdown-item" href="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item" type="submit">
                            <i class='bx bx-log-out'></i> Log Out
                        </button>
                    </form>
                </li> --}}
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item" type="submit">
                            <i class='bx bx-log-out'></i> Log Out
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
