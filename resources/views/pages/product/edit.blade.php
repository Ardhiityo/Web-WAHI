@extends('layouts.app')

@section('content')
    <div class="pt-5 row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Product</h3>
                </div>
                <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="image">Foto</label>
                            <input type="file" name="image" class="form-control form-control-border border-width-2"
                                id="image" value="{{ old('image', $product->image) }}">
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" required
                                class="form-control form-control-border border-width-2" id="name"
                                value="{{ old('name', $product->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="text" name="stock" required
                                class="form-control form-control-border border-width-2" id="stock"
                                value="{{ old('stock', $product->stock) }}">
                        </div>
                        <div class="form-group">
                            <label>Brand</label>
                            <select class="form-control select2" style="width: 100%;" name="brand_id">
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id', $brand->id) === $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="purchase_price">Harga beli</label>
                            <input type="text" name="purchase_price" required
                                class="form-control form-control-border border-width-2"
                                value="{{ old('purchase_price', $product->purchase_price) }}" id="purchase_price">
                        </div>
                        <div class="form-group">
                            <label for="price">Harga jual</label>
                            <input type="text" name="price" required
                                class="form-control form-control-border border-width-2"
                                value="{{ old('price', $product->price) }}" id="price">
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
