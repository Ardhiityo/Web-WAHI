@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Detail Transaksi</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                        <div class="form-group">
                            <label for="transaction_code">Kode Transaksi</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" readonly
                                    value="{{ $transaction->transaction_code }}" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dicount">Diskon {{ $transaction->discountPercentage }}%</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Rp.</span>
                                </div>
                                <input type="text" class="form-control" readonly value="{{ $transaction->total_amount }}"
                                    data-mask>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                        <div class="form-group">
                            <label for="total_amount">Jenis Pembayaran</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-money-check-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" readonly
                                    value="{{ ucfirst($transaction->transaction_type) }}" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="total_amount">Total Harga</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Rp.</span>
                                </div>
                                <input type="text" class="form-control" readonly value="{{ $transaction->total_amount }}"
                                    data-mask>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-end">
                    @if ($transaction->transaction_type == 'cash')
                        <a href="https://wa.me/6287871111101?text=Hallo%20kak,%20saya%20mau%20datang%20ke%20toko,%20kode%20pesanan%20saya%20{{ $transaction->transaction_code }}"
                            class="btn btn-success">Konfirmasi</a>
                    @else
                        <button class="btn btn-success">Bayar</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            @if ($transaction->transaction_type == 'cash')
                Tunjukan Kode Transaksi kepada kasir untuk konfirmasi pembayaran.
            @else
                Tunjukan Kode Transaksi kepada kasir untuk mengambil pesanan jika pembayaran berhasil.
            @endif
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Detail Product</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
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
                                        <img src="{{ asset(Storage::url($cart->product->image)) }}" width="100"
                                            height="100" alt="{{ $cart->product->name }}">
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
        <div class="card-footer">
            Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information
            about
            the plugin.
        </div>
    </div>
@endsection
