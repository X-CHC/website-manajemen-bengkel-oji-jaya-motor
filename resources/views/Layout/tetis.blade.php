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





                        <li class="nav-item {{ request()->routeIs('barang.*') ? 'menu-open' : '' }}">

                    <a href="#" class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">
                        <p>Barang</p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('barang.index') }}"
                            class="nav-link {{ request()->routeIs('barang.index') ? 'active' : '' }}">
                                <p>Daftar Barang</p>
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
