@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Keranjang</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Proses Pesanan</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @if ($carts->isEmpty())
                    <p>Data belum tersedia...</p>
                @else
                    <div class="col-12 d-flex justify-content-around align-items-center">
                        <p class="font-weight-bold">Lanjutkan Proses Pesanan?</p>
                        <a href="{{ route('checkout') }}" class="btn btn-success">Lanjutkan</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Detail Product</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @if ($carts->isEmpty())
                    <p>Data belum tersedia...</p>
                @else
                    <div class="col-12">
                        <div class="container overflow-auto">
                            <table class="table text-center table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No</th>
                                        <th>Foto</th>
                                        <th>Produk</th>
                                        <th>Harga</th>
                                        <th>Quantity</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carts as $cart)
                                        <tr>
                                            <td class="align-middle">{{ $loop->iteration }}</td>
                                            <td class="align-middle">
                                                <img src="{{ asset(Storage::url($cart->product->image)) }}" width="100"
                                                    height="100" alt="{{ $cart->product->name }}" class="rounded">
                                            </td>
                                            <td class="align-middle">{{ $cart->product->name }}</td>
                                            <td class="align-middle text-nowrap">Rp.
                                                {{ number_format($cart->product->price, thousands_separator: '.') }}</td>
                                            <td class="align-middle">{{ $cart->quantity }}</td>
                                            <td class="align-middle text-nowrap">
                                                <a href="{{ route('carts.edit', $cart->id) }}" class="btn btn-warning"> <i
                                                        class="fas fa-edit"></i></a>
                                                <span class="mx-1"></span>
                                                <form action="{{ route('carts.destroy', $cart->id) }}" method="POST"
                                                    style="display: inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Are you sure?')"><i
                                                            class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5 row">
                            <div class="col-12">
                                {{ $carts->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
