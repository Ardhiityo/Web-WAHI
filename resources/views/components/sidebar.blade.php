<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <div class="py-3 user-panel d-flex justify-content-center">
            <div class="image">
                @if (Auth::user()->avatar)
                    <img src="{{ asset(Storage::url(Auth::user()->avatar)) }}" class="img-circle elevation-2"
                        alt="{{ Auth::user()->name }}" width="100" height="100">
                @else
                    <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                        alt="User Image">;
                @endif
            </div>
            <div class="info">
                <a href="{{ route('profile.edit') }}" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="my-2 nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="my-2 nav-item">
                    <a href="{{ route('brands.index') }}"
                        class="nav-link {{ request()->is('brands*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            Brand
                        </p>
                    </a>
                </li>

                <li class="my-2 nav-item">
                    <a href="{{ route('products.index') }}"
                        class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-bag"></i>
                        <p>
                            Produk
                        </p>
                    </a>
                </li>

                <li class="my-2 nav-item">
                    <a href="{{ route('carts.index') }}"
                        class="nav-link {{ request()->is('carts*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cart-arrow-down"></i>
                        <p>
                            Keranjang
                        </p>
                    </a>
                </li>

                <li class="my-2 nav-item">
                    <a href="{{ route('vouchers.index') }}"
                        class="nav-link {{ request()->is('vouchers*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-percent"></i>
                        <p>
                            Voucher
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

                <li class="my-2 nav-item">
                    <a href="{{ route('roles.index') }}"
                        class="nav-link {{ request()->is('roles*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Peran
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
