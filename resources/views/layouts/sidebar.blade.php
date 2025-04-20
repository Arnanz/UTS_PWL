<div class="sidebar">
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