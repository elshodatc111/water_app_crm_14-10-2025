<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center text-center justify-content-between">
    <a href="#" class="logo d-flex align-items-center">
      <span class="d-block d-lg-none">CRM</span>
      <span class="d-none d-lg-block">CRM Center</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div>

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-person-circle" style="font-size: 25px;"></i>
          <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->type }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>{{ auth()->user()->user_name }}</h6>
            <span>{{ auth()->user()->email }}</span>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="#">
              <i class="bi bi-person"></i>
              <span>Profil</span>
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="bi bi-box-arrow-right"></i>
              <span>Chiqish</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</header>

<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

    <!-- Dashboard -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs(['/', 'dashboard']) ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <!-- Aktiv buyurtmalar -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs(['aktive_kent','kent_show']) ? '' : 'collapsed' }}" href="{{ route('aktive_kent') }}">
        <i class="bi bi-lightning-charge"></i>
        <span>Aktiv buyurtmalar</span>
      </a>
    </li>

    <!-- Buyurtmalar -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs(['end_klent']) ? '' : 'collapsed' }}" href="{{ route('end_klent') }}">
        <i class="bi bi-bag-check"></i>
        <span>Yakunlangan buyurtmalar</span>
      </a>
    </li>

    <!-- Omborxona -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs(['sclad','sclad_currer']) ? '' : 'collapsed' }}" href="{{ route('sclad') }}">
        <i class="bi bi-box-seam"></i>
        <span>Omborxona</span>
      </a>
    </li>

    <!-- Kassa -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs(['kassa','kassa_history']) ? '' : 'collapsed' }}" href="{{ route('kassa') }}">
        <i class="bi bi-cash-stack"></i>
        <span>Kassa</span>
      </a>
    </li>

    <!-- Hodimlar -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs(['hodimlar','hodimlar_show']) ? '' : 'collapsed' }}" href="{{ route('hodimlar') }}">
        <i class="bi bi-people"></i>
        <span>Hodimlar</span>
      </a>
    </li>

    <!-- Hisobot -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs(['report_users']) ? '' : 'collapsed' }}" data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-clipboard-data"></i><span>Hisobot</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="report-nav" class="nav-content collapse {{ request()->routeIs(['report_users']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="#" class="{{ request()->routeIs(['report_users']) ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Talabalar</span>
          </a>
        </li>
      </ul>
    </li>

    <!-- Statistika -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs(['stats']) ? '' : 'collapsed' }}" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-graph-up"></i><span>Statistika</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="charts-nav" class="nav-content collapse {{ request()->routeIs(['stats']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="#" class="{{ request()->routeIs(['stats_users']) ? 'active' : '' }}">
            <i class="bi bi-circle"></i><span>Talabalar</span>
          </a>
        </li>
      </ul>
    </li>

    <!-- Sozlamalar -->
    <li class="nav-item">
      <a class="nav-link {{ request()->routeIs(['setting_region','setting_price']) ? '' : 'collapsed' }}" data-bs-target="#setting-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-gear"></i><span>Sozlamalar</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="setting-nav" class="nav-content collapse {{ request()->routeIs(['setting_region','setting_price']) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('setting_region') }}" class="{{ request()->routeIs(['setting_region']) ? 'active' : '' }}">
            <i class="bi bi-geo-alt"></i><span>Hududlar</span>
          </a>
        </li>
        <li>
          <a href="{{ route('setting_price') }}" class="{{ request()->routeIs(['setting_price']) ? 'active' : '' }}">
            <i class="bi bi-currency-dollar"></i><span>Narxlar</span>
          </a>
        </li>
      </ul>
    </li>

  </ul>
</aside>

<main id="main" class="main">
  @yield('content')
</main>

<footer id="footer" class="footer">
  <div class="copyright">
    &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
  </div>
  <div class="credits">
    <strong><span>CodeStart</span></strong> Dev Center
  </div>
</footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <script>
        $(".phone").inputmask("+998 99 999 9999");
    </script>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
  <i class="bi bi-arrow-up-short"></i>
</a>
