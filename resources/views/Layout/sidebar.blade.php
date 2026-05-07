<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">
            AdminLTE
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
                <li class="nav-item has-treeview
                    {{ request()->routeIs('form-barang') || request()->routeIs('daftar-barang') ? 'menu-open' : '' }}">

                    <a href="#"
                       class="nav-link
                       {{ request()->routeIs('form-barang') || request()->routeIs('daftar-barang') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-box"></i>

                        <p>
                            Barang
                            <i class="right fas fa-angle-left"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">

                            <a href="{{ route('form-barang') }}"
                               class="nav-link {{ request()->routeIs('form-barang') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Form Barang</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('daftar-barang') }}"
                               class="nav-link {{ request()->routeIs('daftar-barang') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Daftar Barang</p>

                            </a>

                        </li>

                    </ul>

                </li>


                {{-- MENU KATEGORI --}}
                <li class="nav-item has-treeview
                    {{ request()->routeIs('form-kategori') || request()->routeIs('daftar-kategori') ? 'menu-open' : '' }}">

                    <a href="#"
                       class="nav-link
                       {{ request()->routeIs('form-kategori') || request()->routeIs('daftar-kategori') ? 'active' : '' }}">

                        <i class="nav-icon fas fa-tags"></i>

                        <p>
                            Kategori Barang
                            <i class="right fas fa-angle-left"></i>
                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">

                            <a href="{{ route('form-kategori') }}"
                               class="nav-link {{ request()->routeIs('form-kategori') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Form Kategori</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('daftar-kategori') }}"
                               class="nav-link {{ request()->routeIs('daftar-kategori') ? 'active' : '' }}">

                                <i class="far fa-circle nav-icon"></i>

                                <p>Daftar Kategori</p>

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
