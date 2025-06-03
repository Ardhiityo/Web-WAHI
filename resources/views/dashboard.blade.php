@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>Selamat Datang, {{ Auth::user()->name }}!</h3>
        </div>
    </div>
    <div class="mt-3 row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $customers }}</h3>
                    <p>Pelanggan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('roles.index') }}" class="small-box-footer">Selengkapnya <i
                        class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $cashiers }}</h3>
                    <p>Kasir</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <a href="{{ route('roles.index') }}" class="small-box-footer">Selengkapnya <i
                        class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $brands }}</h3>
                    <p>Brand</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tags"></i>
                </div>
                <a href="{{ route('brands.index') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $products }}</h3>
                    <p>Produk</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('products.index') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $carts }}</h3>
                    <p>Keranjang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cart-arrow-down"></i>
                </div>
                <a href="{{ route('carts.index') }}" class="small-box-footer">
                    Selengkapnya <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $vouchers }}</h3>
                    <p>Voucher</p>
                </div>
                <div class="icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <a href="{{ route('vouchers.index') }}" class="small-box-footer">Selengkapnya <i
                        class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $transactions }}</h3>
                    <p>Transaksi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="{{ route('transactions.index') }}" class="small-box-footer">Selengkapnya <i
                        class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
