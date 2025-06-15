@extends('layouts.app')

@section('content')
    <div class="pt-5 row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit diskon</h3>
                </div>
                <form action="{{ route('discounts.update', ['discount' => $discount->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="discount">Diskon (%)</label>
                            <input type="number" name="discount" required
                                class="form-control form-control-border border-width-2" id="discount"
                                value="{{ $discount->discount }}">
                        </div>
                        <div class="form-group">
                            <label for="untill_date">Berlaku Hingga</label>
                            <input type="date" name="untill_date" required
                                class="form-control form-control-border border-width-2"
                                value="{{ $discount->untill_date->toDateString() }}" id="untill_date">
                        </div>
                        <div class="form-group">
                            <label>Produk</label>
                            <select class="form-control select2" style="width: 100%;" name="product_id" required>
                                <option selected="selected" value="">Pilih...</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ $discount->product_id === $product->id ? 'selected' : '' }}>{{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-5 row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
