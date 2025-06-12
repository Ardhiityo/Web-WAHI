@extends('layouts.app')

@section('content')
    <div class="pt-5 row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Tambah Diskon</h3>
                </div>
                <form action="{{ route('discounts.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="code">Kode</label>
                            <input type="text" name="code" required
                                class="form-control form-control-border border-width-2" id="code">
                        </div>
                        <div class="form-group">
                            <label for="discount">Diskon (%)</label>
                            <input type="number" name="discount" required
                                class="form-control form-control-border border-width-2" id="discount">
                        </div>
                        <div class="form-group">
                            <label>Produk</label>
                            <select class="form-control select2" style="width: 100%;" name="product_id" required>
                                <option selected="selected" value="">Pilih...</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
