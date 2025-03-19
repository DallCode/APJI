<nav class="col-md-3 col-lg-2 d-md-block custom-sidebar">
  <div class="position-sticky pt-3">

    <div class="sidebar-label">Dashboard</div>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
          <i class='bx bx-home'></i> Dashboard
        </a>
      </li>
    </ul>

    <div class="sidebar-label">Menu</div>
    <ul class="nav flex-column">
      
      <!-- Event -->
      <li class="nav-item">
        <a class="sidebar-link {{ request()->routeIs('event.*') ? 'active' : '' }}" href="#eventMenu" data-bs-toggle="collapse" role="button" 
           aria-expanded="{{ request()->routeIs('event.*') ? 'true' : 'false' }}" aria-controls="eventMenu">
          <i class='bx bx-calendar-event'></i> Event
          <i class="bx bx-chevron-right ms-2 toggle-icon"></i>
        </a>
        <div class="collapse {{ request()->routeIs('event.*') ? 'show' : '' }}" id="eventMenu">
          <ul class="nav flex-column ms-3">
            <li class="nav-item">
              <a class="sidebar-link {{ request()->routeIs('admin.event') ? 'active' : '' }}" href="{{ route('admin.event') }}">
                <i class='bx bx-check-circle'></i> Event
              </a>
            </li>
            <li class="nav-item">
              <a class="sidebar-link {{ request()->routeIs('admin.event-riwayat') ? 'active' : '' }}" href="{{ route('admin.event-riwayat') }}">
                <i class='bx bx-history'></i> Riwayat Event
              </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Pengajuan -->
      <li class="nav-item">
        <a class="sidebar-link {{ request()->routeIs('pengajuan.*') ? 'active' : '' }}" href="#pengajuanMenu" data-bs-toggle="collapse" role="button" 
           aria-expanded="{{ request()->routeIs('pengajuan.*') ? 'true' : 'false' }}" aria-controls="pengajuanMenu">
          <i class='bx bx-archive'></i> Pengajuan
          <i class="bx bx-chevron-right ms-2 toggle-icon"></i>
        </a>
        <div class="collapse {{ request()->routeIs('pengajuan.*') ? 'show' : '' }}" id="pengajuanMenu">
          <ul class="nav flex-column ms-3">
            <li class="nav-item">
              <a class="sidebar-link {{ request()->routeIs('halal') ? 'active' : '' }}" href="{{ route('halal') }}">
                <i class='bx bx-check-circle'></i> Halal
              </a>
            </li>
            <li class="nav-item">
              <a class="sidebar-link {{ request()->routeIs('koki') ? 'active' : '' }}" href="{{ route('koki') }}">
                <i class='bx bxs-chef'></i> Koki
              </a>
            </li>
            <li class="nav-item">
              <a class="sidebar-link {{ request()->routeIs('asisten') ? 'active' : '' }}" href="{{ route('asisten') }}">
                <i class='bx bx-user-check'></i> Asisten Koki
              </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Kelayakan -->
      <li class="nav-item">
        <a class="sidebar-link {{ request()->routeIs('kelayakan.*') ? 'active' : '' }}" href="#KelayakanMenu" data-bs-toggle="collapse" role="button" 
           aria-expanded="{{ request()->routeIs('kelayakan.*') ? 'true' : 'false' }}" aria-controls="KelayakanMenu">
          <i class='bx bx-bar-chart-alt-2'></i> Kelayakan
          <i class="bx bx-chevron-right ms-2 toggle-icon"></i>
        </a>
        <div class="collapse {{ request()->routeIs('kelayakan.*') ? 'show' : '' }}" id="KelayakanMenu">
          <ul class="nav flex-column ms-3">
            <li class="nav-item">
              <a class="sidebar-link {{ request()->routeIs('finansial') ? 'active' : '' }}" href="{{ route('finansial') }}">
                <i class='bx bx-wallet'></i> Finansial
              </a>
            </li>
            <li class="nav-item">
              <a class="sidebar-link {{ request()->routeIs('operasional') ? 'active' : '' }}" href="{{ route('operasional') }}">
                <i class='bx bx-wrench'></i> Operasional
              </a>
            </li>
            <li class="nav-item">
              <a class="sidebar-link {{ request()->routeIs('pemasaran') ? 'active' : '' }}" href="{{ route('pemasaran') }}">
                <i class='bx bx-line-chart'></i> Pemasaran
              </a>
            </li>
          </ul>
        </div>
      </li>

    </ul>

  </div>
</nav>
