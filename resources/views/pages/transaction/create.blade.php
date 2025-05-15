@extends('layouts.app')

@section('content')
    <div class="row pt-5">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create Transaction</h3>
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
                <form method="POST" action="{{ route('transactions.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Product</label>
                            <select name="product_id" class="custom-select form-control-border" id="exampleSelectBorder">
                                <option value="">Choose products...</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">Qty</label>
                            <input type="number" name="qty" required
                                class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2">
                        </div>
                        <div class="form-group">
                            <label for="exampleSelectBorder3">Cashier</label>
                            <select name="user_id" class="custom-select form-control-border" id="exampleSelectBorder3">
                                <option>Choose cashiers...</option>
                                @foreach ($cashiers as $cashier)
                                    <option value="{{ $cashier->id }}">{{ $cashier->name }}</option>
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
