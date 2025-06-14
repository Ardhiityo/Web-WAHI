@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Produk</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Cari produk</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('products.index') }}" method="get">
                <div class="mb-4 row">
                    <div class="col-6">
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="form-group">
                                <label for="voucher">Kategori</label>
                                <div class="input-group">
                                    <div class="input-group-prepend w-100">
                                        <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        <select class="form-control select2" name="category" required id="category">
                                            <option value="product">Produk</option>
                                            <option value="brand">Brand</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="form-group">
                                <label for="keyword">Kata kunci</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="keyword">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="mt-3 ml-2 btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-default collapsed-card">
        <div class="card-header">
            <h3 class="card-title">Cari harga</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('products.index') }}" method="get">
                <div class="mb-4 row">
                    <div class="col-6">
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="form-group">
                                <label for="start_price">Minimum</label>
                                <div class="input-group">
                                    <div class="input-group-prepend w-100">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        <input type="number" name="start_price" required
                                            class="form-control form-control-border border-width-2" id="start_price"
                                            value="{{ old('start_price') }}" min="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="form-group">
                                <label for="end_price">Maximum</label>
                                <div class="input-group">
                                    <div class="input-group-prepend w-100">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                        <input type="number" name="end_price" required
                                            class="form-control form-control-border border-width-2" id="end_price"
                                            value="{{ old('end_price') }}" min="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="mt-3 ml-2 btn btn-primary">Cari</button>
                </div>
            </form>
        </div>
    </div>


    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Semua produk</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            @role('owner')
                <div class="mb-4 row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end align-items-center">
                            <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            @endrole
            <div class="row">
                <div class="col-12">
                    @if ($products->isEmpty())
                        <p>Data belum tersedia...</p>
                    @else
                        <div class="container overflow-auto">
                            <table class="table text-center table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No</th>
                                        <th>Foto</th>
                                        <th>Produk</th>
                                        @if (Auth::user()->hasRole('owner'))
                                            <th>Haga beli</th>
                                            <th>Haga jual</th>
                                        @else
                                            <th>Harga</th>
                                        @endif
                                        <th>Stok</th>
                                        <th>Brand</th>
                                        @hasrole('cashier|customer')
                                            <th>Keranjang</th>
                                        @endhasrole
                                        @role('owner')
                                            <th>Aksi</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="align-middle">
                                                {{-- mulai 1, 11, 21, … --}}
                                                {{ $products->firstItem() + $loop->index }}
                                            </td>
                                            <td class="align-middle">
                                                <img src="{{ asset(Storage::url($product->image)) }}" width="100"
                                                    height="100" alt="{{ $product->name }}" class="rounded">
                                            </td>
                                            <td class="align-middle">{{ $product->name }}</td>
                                            @if (Auth::user()->hasRole('owner'))
                                                <td class="align-middle text-nowrap">Rp.
                                                    {{ number_format($product->purchase_price, thousands_separator: '.') }}
                                                </td>
                                                <td class="align-middle text-nowrap">Rp.
                                                    {{ number_format($product->price, thousands_separator: '.') }}
                                                </td>
                                            @else
                                                <td class="align-middle text-nowrap">Rp.
                                                    {{ number_format($product->price, thousands_separator: '.') }}</td>
                                            @endif
                                            <td class="align-middle">{{ $product->stock }}</td>
                                            <td class="align-middle">{{ $product->brand->name }}</td>
                                            @hasrole('customer|cashier')
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
                                            @endhasrole
                                            @role('owner')
                                                <td class="align-middle text-nowrap">
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <span class="mx-1"></span>
                                                    <form action="{{ route('products.destroy', $product->id) }}"
                                                        method="POST" style="display: inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endrole
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5 row">
                            <div class="col-12">
                                {{ $products->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
