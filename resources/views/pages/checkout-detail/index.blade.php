@extends('layouts.app')

@section('content')
    <div class="mt-5 row">
        <div class="col-md-12">
            <div class="card">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="m-3 d-flex justify-content-end align-items-center">
                        @if ($transaction->transaction_type == 'cash')
                            <a href="" class="btn btn-success">Konfirmasi Toko</a>
                        @else
                            <button class="btn btn-success">Bayar</button>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="transaction_code">Kode Transaksi</label>
                                        <input type="text" name="transaction_code" readonly required
                                            class="form-control form-control-border border-width-2"
                                            value="{{ $transaction->transaction_code }}" id="transaction_code">
                                    </div>
                                    <div class="form-group">
                                        <label for="voucher_id">Diskon</label>
                                        <input type="text" name="voucher_id" required readonly
                                            value="{{ $transaction->voucher ?? '-' }}"
                                            class="form-control form-control-border border-width-2" id="voucher_id">
                                    </div>
                                    <div class="form-group">
                                        <label for="transaction_type">Tipe Pembayaran</label>
                                        <input type="text" name="transaction_type" required readonly
                                            value="{{ $transaction->transaction_type }}"
                                            class="form-control form-control-border border-width-2" id="transaction_type">
                                    </div>
                                    <div class="form-group">
                                        <label for="total_amount">Total Harga</label>
                                        <input type="text" name="voucher" required readonly
                                            value="{{ $transaction->total_amount }}"
                                            class="form-control form-control-border border-width-2" id="total_amount">
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
