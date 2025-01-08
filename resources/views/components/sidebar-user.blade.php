<nav class="col-md-3 col-lg-2 d-md-block custom-sidebar">
    <div class="position-sticky pt-3">
        <!-- Sidebar label -->
        <div class="sidebar-label">Main Menu</div>

        <!-- Sidebar menu items -->
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="sidebar-link {{ request()->is('anggota/dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-home custom-icon'></i> 
                        <span class="small-text">Dashboard</span>
                    </div>
                </a>
            </li>
        </ul>

        {{-- <ul class="nav flex-column">
            <li class="nav-item">
                <a class="sidebar-link {{ request()->is('event-anggota') ? 'active' : '' }}" href="/event-anggota">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-calendar-event custom-icon'></i> 
                        <span class="small-text">Event</span>
                    </div>
                </a>
            </li>
        </ul> --}}

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="sidebar-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#eventMenu" role="button" aria-expanded="false" aria-controls="eventMenu">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-calendar-event custom-icon'></i> 
                        <span class="small-text">Event</span>
                    </div>
                    <i class="bx bx-chevron-down"></i>
                </a>
                <div class="collapse" id="eventMenu">
                    <ul class="list-unstyled ms-3">
                        <li class="nav-item">
                            <a class="sidebar-link {{ request()->is('event-anggota') ? 'active' : '' }}" href="/event-anggota">
                                <div class="d-flex align-items-center">
                                    <i class='bx bx-calendar-plus custom-icon'></i>
                                    <span class="small-text">Event Terbaru</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="sidebar-link {{ request()->is('riwayat-event') ? 'active' : '' }}" href="/riwayat-event">
                                <div class="d-flex align-items-center">
                                    <i class='bx bx-history custom-icon'></i>
                                    <span class="small-text">Riwayat Event</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="sidebar-link {{ request()->is('pengajuan-sertifikat') ? 'active' : '' }}" href="/pengajuan-sertifikat">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-book-bookmark custom-icon'></i>
                        <span class="small-text">Pengajuan Sertifikat</span> <!-- Pengajuan sejajar dengan logo -->
                    </div>    
                </a>
            </li>
        </ul>            
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="sidebar-link {{ request()->is('kelayakan-usaha') ? 'active' : '' }}" href="/kelayakan-usaha">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-task custom-icon'></i> 
                        <span class="small-text">Kelayakan Usaha</span>
                    </div>
                </a>
            </li>
        </ul>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="sidebar-link {{ request()->is('profile-user') ? 'active' : '' }}" href="/profile-user">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-user-circle custom-icon'></i> 
                        <span class="small-text">Profile</span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Pastikan kita hanya mencegah penutupan jika elemen dalam dropdown diklik
        const dropdownLinks = document.querySelectorAll('#eventMenu .sidebar-link');
        
        dropdownLinks.forEach(function(link) {
            link.addEventListener('click', function (e) {
                e.stopPropagation(); // Mencegah dropdown tertutup saat link di dalamnya diklik
            });
        });
    });
</script>
