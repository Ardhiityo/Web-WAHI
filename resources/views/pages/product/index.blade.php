@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Daftar Produk</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-4 row">
                <div class="col-12">
                    <div class="d-flex justify-content-end align-items-center">
                        <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-around">
                    <table class="table text-center table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Brand</th>
                                <th>Keranjang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">
                                        <img src="{{ asset(Storage::url($product->image)) }}" width="100" height="100"
                                            alt="{{ $product->name }}">
                                    </td>
                                    <td class="align-middle">{{ $product->name }}</td>
                                    <td class="align-middle">Rp.
                                        {{ number_format($product->price, thousands_separator: '.') }}</td>
                                    <td class="align-middle">{{ $product->stock }}</td>
                                    <td class="align-middle">{{ $product->brand->name }}</td>
                                    <td class="align-middle">
                                        <form action="{{ route('carts.store') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            @if ($product->stock < 1)
                                                <button disabled class="btn btn-success">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-warning">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <span class="mx-1"></span>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5 row">
                        <div class="col-12">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            Semua daftar product
        </div>
    </div>
@endsection
