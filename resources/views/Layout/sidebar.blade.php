<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/img/logo.jpg') }}"
             alt="Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8; width: 40px; height: 40px; max-height: none; margin-top: -5px;">

        <span class="brand-text font-weight-light">
            Bengkel Oji Jaya
        </span>
    </a>

    @php
        use Illuminate\Support\Facades\Cache;

        $userLogin = auth()->user();

        $modeStockOpname = Cache::get('stock_opname_mode', false);

        /*
        |--------------------------------------------------------------------------
        | AKSES PARENT MENU
        |--------------------------------------------------------------------------
        */
        $canDashboard = punyaAksesMenu('dashboard.index', $userLogin);

        $canBarang = punyaAksesMenu('barang.index', $userLogin)
            || punyaAksesMenu('barang.create', $userLogin);

        $canKategori = punyaAksesMenu('kategori.index', $userLogin)
            || punyaAksesMenu('kategori.create', $userLogin);

        $canPelanggan = punyaAksesMenu('pelanggan.index', $userLogin)
            || punyaAksesMenu('pelanggan.create', $userLogin);

        $canTransaksi = punyaAksesMenu('transaksi.index', $userLogin)
            || punyaAksesMenu('transaksi.create', $userLogin);

        $canPo = punyaAksesMenu('po.index', $userLogin)
            || punyaAksesMenu('po.create', $userLogin);

        $canBarangMasuk = punyaAksesMenu('barang-masuk.index', $userLogin)
            || punyaAksesMenu('barang-masuk.create', $userLogin);

        $canHistory = punyaAksesMenu('history.index', $userLogin);

        $canLaporan = punyaAksesMenu('laporan.index', $userLogin);

        $canStockOpname = punyaAksesMenu('stock-opname.create', $userLogin);

        $canUser = punyaAksesMenu('user.index', $userLogin)
            || punyaAksesMenu('user.create', $userLogin);

        $canRole = punyaAksesMenu('role.index', $userLogin)
            || punyaAksesMenu('role.create', $userLogin);
    @endphp

    <div class="sidebar">

        <nav>

            <ul class="nav nav-pills nav-sidebar flex-column"data-widget="treeview"role="menu"data-accordion="false">
                @if($modeStockOpname)

                    <li class="nav-header text-danger">
                        MODE STOCK OPNAME AKTIF
                    </li>

                @endif

                {{-- Dashboard --}}
                @if($canDashboard)

                    @if(punyaAksesMenu('dashboard.index', $userLogin))
                        <li class="nav-item">
                            <a href="{{ route('dashboard.index') }}"
                            class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">

                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>

                            </a>
                        </li>
                    @endif

                @endif



                {{-- MENU BARANG --}}
                @if($canBarang)
                    <li class="nav-item has-treeview {{ request()->routeIs('barang.*') ? 'menu-open' : '' }}">

                        <a href="#"
                        class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-box"></i>

                            <p>
                                Barang
                                <i class="right fas fa-angle-left"></i>
                            </p>

                        </a>

                        <ul class="nav nav-treeview">

                            @if(punyaAksesMenu('barang.create', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('barang.create') }}"
                                    class="nav-link {{ request()->routeIs('barang.create') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Barang</p>

                                    </a>
                                </li>
                            @endif

                            @if(punyaAksesMenu('barang.index', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('barang.index') }}"
                                    class="nav-link {{ request()->routeIs('barang.index') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Barang</p>

                                    </a>
                                </li>
                            @endif

                        </ul>

                    </li>
                @endif


                {{-- MENU KATEGORI --}}
                @if($canKategori)
                    <li class="nav-item has-treeview {{ request()->routeIs('kategori.*') ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-tags"></i>

                            <p>
                                Kategori
                                <i class="right fas fa-angle-left"></i>
                            </p>

                        </a>

                        <ul class="nav nav-treeview">
                            @if(punyaAksesMenu('kategori.create', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('kategori.create') }}"
                                    class="nav-link {{ request()->routeIs('kategori.create') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Kategori</p>

                                    </a>
                                </li>
                            @endif

                            @if(punyaAksesMenu('kategori.index', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('kategori.index') }}"
                                    class="nav-link {{ request()->routeIs('kategori.index') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Kategori</p>

                                    </a>
                                </li>
                            @endif
                        </ul>

                    </li>
                @endif


                {{-- MENU PELANGGAN --}}
                @if($canPelanggan)
                    <li class="nav-item has-treeview {{ request()->routeIs('pelanggan.*') ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-users"></i>

                            <p>
                                Pelanggan
                                <i class="right fas fa-angle-left"></i>
                            </p>

                        </a>

                        <ul class="nav nav-treeview">
                            @if(punyaAksesMenu('pelanggan.create', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('pelanggan.create') }}"
                                    class="nav-link {{ request()->routeIs('pelanggan.create') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Pelanggan</p>

                                    </a>
                                </li>
                            @endif
                            @if(punyaAksesMenu('pelanggan.index', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('pelanggan.index') }}"
                                    class="nav-link {{ request()->routeIs('pelanggan.index') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Pelanggan</p>

                                    </a>
                                </li>
                            @endif
                        </ul>

                    </li>

                @endif


                {{-- MENU TRANSAKSI --}}
                @if($canTransaksi)
                    <li class="nav-item has-treeview {{ request()->routeIs('transaksi.*') ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-cash-register"></i>

                            <p>
                                Transaksi
                                <i class="right fas fa-angle-left"></i>
                            </p>

                        </a>

                        <ul class="nav nav-treeview">

                            @if(punyaAksesMenu('transaksi.create', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('transaksi.create') }}"
                                       class="nav-link {{ request()->routeIs('transaksi.create') ? 'active' : '' }}">

                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Buat Transaksi</p>

                                    </a>
                                </li>
                            @endif

                            @if(punyaAksesMenu('transaksi.index', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('transaksi.index') }}"
                                       class="nav-link {{ request()->routeIs('transaksi.index') ? 'active' : '' }}">

                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List Transaksi</p>

                                    </a>
                                </li>
                            @endif

                        </ul>

                    </li>
                @endif


                {{-- MENU PO --}}
                @if($canPo)
                    <li class="nav-item has-treeview {{ request()->routeIs('po.*') ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs('po.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-file-invoice"></i>

                            <p>
                                Purchase Order
                                <i class="right fas fa-angle-left"></i>
                            </p>

                        </a>

                        <ul class="nav nav-treeview">

                            @if(punyaAksesMenu('po.create', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('po.create') }}"
                                       class="nav-link {{ request()->routeIs('po.create') ? 'active' : '' }}">

                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Buat PO</p>

                                    </a>
                                </li>
                            @endif

                            @if(punyaAksesMenu('po.index', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('po.index') }}"
                                       class="nav-link {{ request()->routeIs('po.index') ? 'active' : '' }}">

                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List PO</p>

                                    </a>
                                </li>
                            @endif

                        </ul>

                    </li>
                @endif


                {{-- MENU BARANG MASUK --}}
                @if($canBarangMasuk)
                    <li class="nav-item has-treeview {{ request()->routeIs('barang-masuk.*') ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs('barang-masuk.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-truck"></i>

                            <p>
                                Barang Masuk
                                <i class="right fas fa-angle-left"></i>
                            </p>

                        </a>

                        <ul class="nav nav-treeview">

                            @if(punyaAksesMenu('barang-masuk.create', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('barang-masuk.create') }}"
                                       class="nav-link {{ request()->routeIs('barang-masuk.create') ? 'active' : '' }}">

                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tambah Barang Masuk</p>

                                    </a>
                                </li>
                            @endif
                            @if(punyaAksesMenu('barang-masuk.index', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('barang-masuk.index') }}"
                                    class="nav-link {{ request()->routeIs('barang-masuk.index') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Barang Masuk</p>

                                    </a>
                                </li>
                            @endif

                        </ul>

                    </li>
                @endif


                {{-- HISTORY STOK --}}
                @if(punyaAksesMenu('history.index', $userLogin))
                    <li class="nav-item">
                        <a href="{{ route('history.index') }}"
                        class="nav-link {{ request()->routeIs('history.index') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-history"></i>

                            <p>Lihat History Stok</p>

                        </a>
                    </li>

                @endif


                {{-- LAPORAN --}}
                @if(punyaAksesMenu('laporan.index', $userLogin))
                    <li class="nav-item">
                        <a href="{{ route('laporan.index') }}"
                           class="nav-link {{ request()->routeIs('laporan.index') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-chart-bar"></i>

                            <p>Lihat Laporan</p>

                        </a>
                    </li>
                @endif

                {{-- STOCK OPNAME --}}
                @if(
                    punyaAksesMenu('stock-opname.index', $userLogin) ||
                    punyaAksesMenu('stock-opname.create', $userLogin)
                )
                    <li class="nav-item has-treeview {{ request()->routeIs('stock-opname.*') ? 'menu-open' : '' }}">

                        <a href="#"
                        class="nav-link {{ request()->routeIs('stock-opname.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-clipboard-check"></i>

                            <p>
                                Stock Opname
                                <i class="right fas fa-angle-left"></i>
                            </p>

                        </a>

                        <ul class="nav nav-treeview">

                                                        @if(punyaAksesMenu('stock-opname.create', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('stock-opname.create') }}"
                                    class="nav-link {{ request()->routeIs('stock-opname.create') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>

                                        <p>Stock Opname</p>

                                    </a>
                                </li>
                            @endif

                            @if(punyaAksesMenu('stock-opname.index', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('stock-opname.index') }}"
                                    class="nav-link {{ request()->routeIs('stock-opname.index') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>

                                        <p>Riwayat Stock Opname</p>

                                    </a>
                                </li>
                            @endif




                        </ul>

                    </li>
                @endif

                {{-- MENU AKUN  --}}
                @if($canUser)

                    <li class="nav-item has-treeview {{ request()->routeIs('user.*') ? 'menu-open' : '' }}">

                        <a href="#"
                        class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-user-cog"></i>

                            <p>
                                Akun
                                <i class="right fas fa-angle-left"></i>
                            </p>

                        </a>

                        <ul class="nav nav-treeview">
                            @if(punyaAksesMenu('user.create', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('user.create') }}"
                                    class="nav-link {{ request()->routeIs('user.create') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Akun</p>

                                    </a>
                                </li>
                            @endif
                            @if(punyaAksesMenu('user.index', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('user.index') }}"
                                    class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Akun</p>

                                    </a>
                                </li>
                            @endif
                        </ul>

                    </li>

                @endif

                @if(punyaAksesMenu('role.index', $userLogin) || punyaAksesMenu('role.create', $userLogin))
                    <li class="nav-item has-treeview {{ request()->routeIs('role.*') ? 'menu-open' : '' }}">

                        <a href="#"
                        class="nav-link {{ request()->routeIs('role.*') ? 'active' : '' }}">

                            <i class="nav-icon fas fa-user-shield"></i>

                            <p>
                                Role
                                <i class="right fas fa-angle-left"></i>
                            </p>

                        </a>

                        <ul class="nav nav-treeview">

                            @if(punyaAksesMenu('role.create', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('role.create') }}"
                                    class="nav-link {{ request()->routeIs('role.create') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Role</p>

                                    </a>
                                </li>
                            @endif

                            @if(punyaAksesMenu('role.index', $userLogin))
                                <li class="nav-item">
                                    <a href="{{ route('role.index') }}"
                                    class="nav-link {{ request()->routeIs('role.index') ? 'active' : '' }}">

                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Role</p>

                                    </a>
                                </li>
                            @endif

                        </ul>

                    </li>
                @endif

            </ul>

        </nav>

    </div>

</aside>
