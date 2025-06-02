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
            <div class="row">
                <div class="col-12">
                    <div class="m-3 d-flex justify-content-end align-items-center">
                        <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-around">
                    <table class="table table-bordered">
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
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset(Storage::url($product->image)) }}" width="100" height="100"
                                            alt="{{ $product->name }}">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>Rp. {{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->brand->name }}</td>
                                    <td>
                                        <form action="{{ route('carts.store') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button class="btn btn-warning">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-primary">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                            style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete</button>
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
