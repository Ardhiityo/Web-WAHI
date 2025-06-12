@extends('layouts.app')

@section('content')
    <div class="pt-5 row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Produk</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">Foto</label>
                            <input type="file" name="image" required
                                class="form-control form-control-border border-width-2" id="image">
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" required
                                class="form-control form-control-border border-width-2" id="name">
                        </div>
                        <div class="form-group">
                            <label for="purchase_price">Harga beli</label>
                            <input type="text" name="purchase_price" required
                                class="form-control form-control-border border-width-2" id="purchase_price">
                        </div>
                        <div class="form-group">
                            <label for="price">Harga jual</label>
                            <input type="text" name="price" required
                                class="form-control form-control-border border-width-2" id="price">
                        </div>
                        <div class="form-group">
                            <label for="stock">Stok</label>
                            <input type="text" name="stock" required
                                class="form-control form-control-border border-width-2" id="stock">
                        </div>
                        <div class="form-group">
                            <label>Brand</label>
                            <select class="form-control select2" style="width: 100%;" name="brand_id" required>
                                <option selected="selected" value="">Pilih...</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-5 row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
