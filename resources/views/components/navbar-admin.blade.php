<nav class="navbar custom-nav">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="{{ asset('assets/img/logo/apjiadmin.png') }}" alt=""></a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-danger ml-auto" type="submit">
                    <i class='bx bx-log-out'></i>
                </button>
            </form>
    </div>
</nav>