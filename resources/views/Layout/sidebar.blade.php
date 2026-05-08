<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">
            Sahabat Selamanya
        </span>
    </a>

    <div class="sidebar">

        <nav>

            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">

                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-home"></i>

                        <p>Dashboard</p>

                    </a>

                </li>


                {{-- MENU BARANG --}}
                <li class="nav-item {{ request()->routeIs('barang.*') ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Barang</p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('barang.index') }}"
                            class="nav-link {{ request()->routeIs('barang.index') ? 'active' : '' }}">
                                <p>List Barang</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('barang.create') }}"
                            class="nav-link {{ request()->routeIs('barang.create') ? 'active' : '' }}">
                                <p>Tambah Barang</p>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- MENU KATEGORI --}}
                <li class="nav-item {{ request()->routeIs('kategori.*') ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>Kategori</p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">

                            <a href="{{ route('kategori.create') }}"
                               class="nav-link {{ request()->routeIs('kategori.create') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Tambah Kategori</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('kategori.index') }}"
                               class="nav-link {{ request()->routeIs('kategori.index') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>List Kategori</p>

                            </a>

                        </li>

                    </ul>

                </li>

                {{-- MENU PELANGGAN --}}
                <li class="nav-item {{ request()->routeIs('pelanggan.*') ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Pelanggan</p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('pelanggan.create') }}"
                               class="nav-link {{ request()->routeIs('pelanggan.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Pelanggan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('pelanggan.index') }}"
                               class="nav-link {{ request()->routeIs('pelanggan.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Pelanggan</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- MENU TRANSAKSI --}}
                <li class="nav-item {{ request()->routeIs('transaksi.*') ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>Transaksi</p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('transaksi.create') }}"
                               class="nav-link {{ request()->routeIs('transaksi.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Buat Transaksi</p>
                            </a>
                        </li>

                    </ul>

                </li>

                {{-- Logout --}}
                <li class="nav-item">

                    <form action="{{ route('logout') }}" method="POST">

                        @csrf

                        <button type="submit"
                                class="btn btn-danger btn-sm ml-3 mt-2">

                            Logout

                        </button>

                    </form>

                </li>

            </ul>

        </nav>

    </div>

</aside>
