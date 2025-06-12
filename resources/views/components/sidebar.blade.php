<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <div class="py-3 user-panel d-flex justify-content-center">
            <div class="text-center text-white info">
                <i class="fas fa-store"></i> <br>
                <span class="d-block lead font-weight-bold">WAHI MART</span>
            </div>
        </div>

        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="my-2 nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                @role('owner')
                    <li class="my-2 nav-item">
                        <a href="{{ route('brands.index') }}"
                            class="nav-link {{ request()->is('brands*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>
                                Brand
                            </p>
                        </a>
                    </li>
                @endrole

                <li class="my-2 nav-item">
                    <a href="{{ route('products.index') }}"
                        class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>
                            Produk
                        </p>
                    </a>
                </li>

                @hasrole('cashier|customer')
                    <li class="my-2 nav-item">
                        <a href="{{ route('carts.index') }}" class="nav-link {{ request()->is('carts*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cart-arrow-down"></i>
                            <p>
                                Keranjang
                            </p>
                        </a>
                    </li>
                @endhasrole

                <li class="my-2 nav-item">
                    <a href="{{ route('discounts.index') }}"
                        class="nav-link {{ request()->is('discounts*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-percent"></i>
                        <p>
                            Potongan
                        </p>
                    </a>
                </li>

                <li class="my-2 nav-item">
                    <a href="{{ route('transactions.index') }}"
                        class="nav-link {{ request()->is('transactions*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>
                            Transaksi
                        </p>
                    </a>
                </li>

                @role('owner')
                    <li class="my-2 nav-item">
                        <a href="{{ route('profits.index') }}"
                            class="nav-link {{ request()->is('profits*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-funnel-dollar"></i>
                            <p>
                                Pendapatan
                            </p>
                        </a>
                    </li>
                @endrole

                @hasrole('owner')
                    <li class="my-2 nav-item">
                        <a href="{{ route('reports.index') }}"
                            class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>
                                Laporan
                            </p>
                        </a>
                    </li>
                @endhasrole

                @role('owner')
                    <li class="my-2 nav-item">
                        <a href="{{ route('roles.index') }}"
                            class="nav-link {{ request()->is('roles*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Peran
                            </p>
                        </a>
                    </li>
                @endrole
            </ul>
        </nav>
    </div>
</aside>
