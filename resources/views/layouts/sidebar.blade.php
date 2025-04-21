<div class="sidebar">
        <!-- Sidebar Search Form -->
        <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
            <!-- Menu Transaksi -->
            <li class="nav-header">MANAJEMEN TRANSAKSI</li>
            <li class="nav-item">
            <a href="{{ route('transaksi.index') }}" 
             class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-wallet"></i>
            <p>Catatan Transaksi</p>
          </a>
        </li>
        </ul>
    </nav>
</div>