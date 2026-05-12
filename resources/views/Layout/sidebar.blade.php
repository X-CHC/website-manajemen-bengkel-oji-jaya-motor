<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('assets/img/logo.jpg') }}"
            alt="Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: .8; width: 40px; height: 40px; max-height: none; margin-top: -5px;">

        <span class="brand-text font-weight-light">Sahabat Selamanya</span>
    </a>

    <div class="sidebar">

        <nav>

            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">

                    <a href="{{ route('dashboard.index') }}"
                       class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">

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
                            <a href="{{ route('barang.create') }}"
                            class="nav-link {{ request()->routeIs('barang.create') ? 'active' : '' }}">
                                <p>Tambah Barang</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('barang.index') }}"
                            class="nav-link {{ request()->routeIs('barang.index') ? 'active' : '' }}">
                                <p>List Barang</p>
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
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('transaksi.index') }}"
                               class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Transaksi</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- MENU PO --}}
                <li class="nav-item {{ request()->routeIs('po.*') ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link {{ request()->routeIs('po.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>Purchase Order</p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('po.index') }}"
                               class="nav-link {{ request()->routeIs('po.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List PO</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('po.create') }}"
                               class="nav-link {{ request()->routeIs('po.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Buat PO</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- MENU BARANG MASUK -->
                <li class="nav-item {{ request()->routeIs('barang-masuk.*') ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link {{ request()->routeIs('barang-masuk.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>Barang Masuk</p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('barang-masuk.create') }}"
                               class="nav-link {{ request()->routeIs('barang-masuk.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Barang Masuk</p>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- History Stock --}}
                <li class="nav-item ">
                    <a href="{{ route('history.index') }}" class="nav-link {{ request()->routeIs('history.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Lihat History Stock</p>
                    </a>
                </li>

                {{-- Laporan --}}
                <li class="nav-item ">

                    <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Lihat Laporan</p>
                    </a>
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
