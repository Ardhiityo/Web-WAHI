@extends('layouts.app')

@section('content')
    <div class="mt-5 row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('carts.checkout.detail') }}" method="POST">
                    @csrf
                    <div class="m-3 d-flex justify-content-end align-items-center">
                        <button class="btn btn-success">Buat Pesanan</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="voucher">Voucher</label>
                                        <input type="text" name="voucher"
                                            class="form-control form-control-border border-width-2" id="voucher">
                                    </div>
                                    <div class="form-group">
                                        <label for="transaction_type">Tipe Pembayaran</label>
                                        <select class="form-control select2" style="width: 100%;" name="transaction_type"
                                            required id="transaction_type">
                                            <option selected="selected" value="">Pilih...</option>
                                            <option value="cashless">Cashless</option>
                                            <option value="cash">Tunai</option>
                                        </select>
                                    </div>
                                </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 10px">No</th>
                    <th>Foto</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carts as $cart)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ asset(Storage::url($cart->product->image)) }}" width="100" height="100"
                                alt="{{ $cart->product->name }}">
                        </td>
                        <td>{{ $cart->product->name }}</td>
                        <td>{{ $cart->product->price }}</td>
                        <td>{{ $cart->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-5 row">
            <div class="col-12">
                {{ $carts->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
