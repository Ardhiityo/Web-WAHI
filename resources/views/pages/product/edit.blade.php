@extends('layouts.app')

@section('content')
    <div class="pt-5 row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Product</h3>
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
                <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">Name</label>
                            <input type="text" name="name" required
                                class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2"
                                value="{{ old('name', $product->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">Price</label>
                            <input type="text" name="price" required
                                class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2"
                                value="{{ old('price', $product->price) }}">
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
