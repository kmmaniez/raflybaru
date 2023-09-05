        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-text mx-3">PURNAMA INVENTORY</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ (request()->is('/') || request()->is('dashboard')) ? 'active' : '' }}">
                <a class="nav-link" href="/">
                    <i class="fas fa-fw fa-desktop"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                barang master
            </div>

            <!-- Nav Item - Tables -->

            <li class="nav-item {{ (request()->is('supplier*')) ? 'active' : '' }}">
                <a class="nav-link" href="/supplier">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Data Supplier</span></a>
            </li>
            
            <li class="nav-item {{ (request()->is('products*')) ? 'active' : '' }}">
                <a class="nav-link" href="/products">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Data Barang</span></a>
            </li>
            
            @if (auth()->user()->is_admin)
            <li class="nav-item {{ (request()->is('barang-masuk*')) ? 'active' : '' }}">
                <a class="nav-link" href="/barang-masuk">
                    <i class="fas fa-fw fa-sign-in-alt"></i>
                    <span>Barang Masuk</span></a>
            </li>

            <li class="nav-item {{ (request()->is('barang-retur*')) ? 'active' : '' }}">
                <a class="nav-link" href="/barang-retur">
                    <i class="fas fa-fw fa-arrow-left"></i>
                    <span>Data Barang Retur</span></a>
            </li>
            
            <li class="nav-item {{ (request()->is('barang-keluar*')) ? 'active' : '' }}">
                <a class="nav-link" href="/barang-keluar">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Barang Keluar</span></a>
            </li>
            @endif
            
            <li class="nav-item {{ (request()->is('laporan-masuk*')) ? 'active' : '' }}">
                <a class="nav-link" href="/laporan-masuk">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Laporan Masuk</span></a>
            </li>
            
            <li class="nav-item {{ (request()->is('laporan-keluar*')) ? 'active' : '' }}">
                <a class="nav-link" href="/laporan-keluar">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Laporan Keluar</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Nav Item - Log Out -->
            <li class="nav-item">
                <form action="{{ route('logout')}}" method="post">
                    @csrf
                    <button class="btn btn-md nav-link">Logout</button>
                </form>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
        