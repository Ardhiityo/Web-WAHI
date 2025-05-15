@extends('layouts.app')

@section('content')
    <div class="row pt-5">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Transaction</h3>
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
                <form method="POST" action="{{ route('transactions.update', ['transaction' => $transaction->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Product</label>
                            <select name="product_id" class="custom-select form-control-border" id="exampleSelectBorder">
                                <option value="">Choose products...</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_id', $product->id) === $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">Qty</label>
                            <input type="number" name="qty" required
                                class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2"
                                value="{{ old('qty', $transaction->qty) }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleSelectBorder3">Cashier</label>
                            <select name="user_id" class="custom-select form-control-border" id="exampleSelectBorder3">
                                <option>Choose cashiers...</option>
                                @foreach ($cashiers as $cashier)
                                    <option value="{{ $cashier->id }}"
                                        {{ old('user_id', $cashier->id) === $cashier->id ? 'selected' : '' }}>
                                        {{ $cashier->name }}
                                    </option>
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
