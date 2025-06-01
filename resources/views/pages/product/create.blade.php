@extends('layouts.app')

@section('content')
    <div class="pt-5 row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Produk</h3>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
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
                            <input type="text" name="price" required
                                class="form-control form-control-border border-width-2" id="stock">
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input type="text" name="brand" required
                                class="form-control form-control-border border-width-2" id="brand">
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
