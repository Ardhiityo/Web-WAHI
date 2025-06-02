@extends('layouts.app')

@section('content')
    <div class="pt-5 row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Produk</h3>
                </div>
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
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
                            <label for="price">Harga</label>
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
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
