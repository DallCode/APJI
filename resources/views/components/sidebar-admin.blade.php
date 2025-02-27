<nav class="col-md-3 col-lg-2 d-md-block custom-sidebar">
    <div class="position-sticky pt-3">
      
      <div class="sidebar-label">Dashboard</div>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="sidebar-link {{ Request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class='bx bx-home'></i> Dashboard
          </a>
        </li>
      </ul>
  
      <div class="sidebar-label">Menu</div>
      <ul class="nav flex-column">
        <!-- Event section remains the same -->
        {{-- <li class="nav-item">
          <a class="sidebar-link {{ Request()->is('admin/event') ? 'active' : '' }}" href="/event">
            <i class='bx bx-calendar-event'></i> Event
          </a>
        </li> --}}

        <li class="nav-item">
          <a class="sidebar-link" href="#eventMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="eventMenu">
            <i class='bx bx-archive'></i> Event
            <i class="bx bx-chevron-right ms-2" id="eventIcon"></i>
          </a>
          <div class="collapse" id="eventMenu">
            <ul class="nav flex-coloumn ms-3">
              <li class="nav-item">
                <a class="sidebar-link {{ Request()->is('event') ? 'active' : '' }}" href="/event">
                  <i class='bx bx-check-circle'></i> Event
                </a>
              </li>
            </ul>
          </div>
          <div class="collapse" id="eventMenu">
            <ul class="nav flex-coloumn ms-3">
              <li class="nav-item">
                <a class="sidebar-link {{ Request()->is('riwayat-event') ? 'active' : '' }}" href="/event-riwayat">
                  <i class='bx bx-check-circle'></i> Riwayat Event
                </a>
              </li>
            </ul>
          </div>
        </li>
        
        <!-- Pengajuan with Dropdown Collapse -->
        <li class="nav-item">
          <a class="sidebar-link" href="#pengajuanMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="pengajuanMenu">
            <i class='bx bx-archive'></i> Pengajuan
            <i class="bx bx-chevron-right ms-2" id="pengajuanIcon"></i> <!-- Dropdown icon -->
          </a>
          <div class="collapse" id="pengajuanMenu">
            <ul class="nav flex-column ms-3">
              <li class="nav-item">
                <a class="sidebar-link {{ Request()->is('halal') ? 'active' : '' }}" href="/halal">
                  <i class='bx bx-check-circle'></i> Halal
                </a>
              </li>
              <li class="nav-item">
                <a class="sidebar-link {{ Request()->is('koki') ? 'active' : '' }}" href="/koki">
                  <i class='bx bx-cook'></i> Koki
                </a>
              </li>
              <li class="nav-item">
                <a class="sidebar-link {{ Request()->is('asisten-koki') ? 'active' : '' }}" href="/asisten-koki">
                  <i class='bx bx-user-check'></i> Asisten Koki
                </a>
              </li>
            </ul>
          </div>
        </li>
  
        <!-- Kelayakan with Dropdown Collapse -->
        <li class="nav-item">
          <a class="sidebar-link" href="#KelayakanMenu" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="KelayakanMenu">
            <i class='bx bx-bar-chart-alt-2'></i> Kelayakan
            <i class="bx bx-chevron-right ms-2" id="kelayakanIcon"></i> <!-- Dropdown icon -->
          </a>
          <div class="collapse" id="KelayakanMenu">
            <ul class="nav flex-column ms-3">
              <li class="nav-item">
                <a class="sidebar-link {{ Request()->is('finansial') ? 'active' : '' }}" href="/finansial">
                  <i class='bx bx-wallet-circle'></i> Finansial
                </a>
              </li>
              <li class="nav-item">
                <a class="sidebar-link {{ Request()->is('operasional') ? 'active' : '' }}" href="/operasional">
                  <i class='bx bx-cogs'></i> Operasional
                </a>
              </li>
              <li class="nav-item">
                <a class="sidebar-link {{ Request()->is('pemasaran') ? 'active' : '' }}" href="/pemasaran">
                  <i class='bx bx-line-chart'></i> Pemasaran
                </a>
              </li>
            </ul>
          </div>
        </li>
  
      </ul>
      
    </div>
  </nav>
  
  <script>
     // Toggle icon for pengajuanMenu
     var eventCollapse = document.getElementById('eventMenu');
    var eventIcon = document.getElementById('eventIcon');
  
    eventCollapse.addEventListener('shown.bs.collapse', function () {
      eventIcon.classList.remove('bx-chevron-right');
      eventIcon.classList.add('bx-chevron-down');
    });
  
    eventCollapse.addEventListener('hidden.bs.collapse', function () {
      eventIcon.classList.remove('bx-chevron-down');
      eventIcon.classList.add('bx-chevron-right');
    });

    // Toggle icon for pengajuanMenu
    var pengajuanCollapse = document.getElementById('pengajuanMenu');
    var pengajuanIcon = document.getElementById('pengajuanIcon');
  
    pengajuanCollapse.addEventListener('shown.bs.collapse', function () {
      pengajuanIcon.classList.remove('bx-chevron-right');
      pengajuanIcon.classList.add('bx-chevron-down');
    });
  
    pengajuanCollapse.addEventListener('hidden.bs.collapse', function () {
      pengajuanIcon.classList.remove('bx-chevron-down');
      pengajuanIcon.classList.add('bx-chevron-right');
    });
  
    // Toggle icon for kelayakanMenu
    var kelayakanCollapse = document.getElementById('KelayakanMenu');
    var kelayakanIcon = document.getElementById('kelayakanIcon');
  
    kelayakanCollapse.addEventListener('shown.bs.collapse', function () {
      kelayakanIcon.classList.remove('bx-chevron-right');
      kelayakanIcon.classList.add('bx-chevron-down');
    });
  
    kelayakanCollapse.addEventListener('hidden.bs.collapse', function () {
      kelayakanIcon.classList.remove('bx-chevron-down');
      kelayakanIcon.classList.add('bx-chevron-right');
    });
  </script>
  