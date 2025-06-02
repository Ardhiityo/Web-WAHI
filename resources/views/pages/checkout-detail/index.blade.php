@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Status Transaksi</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div>
                        @if ($transaction->transaction_type == 'cash')
                            <h4>Sukses dibuat.</h4>
                            <p>Selanjutnya, konfirmasi ke toko dan datangi toko lalu tunjukan kode transaksi kepada kasir
                                untuk
                                konfirmasi pembayaran.</p>
                        @else
                            <h4>Sukses dibuat.</h4>
                            <p>Tunjukan Kode Transaksi kepada kasir untuk mengambil pesanan jika pembayaran
                                sukses.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="my-3 col-12">
                    @if ($transaction->transaction_type == 'cash')
                        <a href="{{ route('transactions.index') }}" class="btn btn-primary">Lihat Transaksi</a>
                        <a href="https://wa.me/6287871111101?text=Hallo%20kak,%20saya%20mau%20datang%20ke%20toko,%20kode%20pesanan%20saya%20{{ $transaction->transaction_code }}"
                            class="btn btn-success">Konfirmasi</a>
                    @else
                        <button class="btn btn-success">Bayar</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

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
                            <label for="dicount">Persentase Diskon</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                </div>
                                <input type="text" class="rounded form-control" readonly
                                    value="{{ $transaction->discount_percentage ?? '0' }}" data-mask>
                                <span class="input-group-text font-weight-bold"><i class="fas fa-percent"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dicount">Total Diskon</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Rp.</span>
                                </div>
                                <input type="text" class="form-control" readonly value="{{ $transaction->discount }}"
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
                            <label for="total_amount">Sub Total</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold">Rp.</span>
                                </div>
                                <input type="text" class="form-control" readonly
                                    value="{{ $transaction->subtotal_amount }}" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="total_amount">Grand Total</label>
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
            </div>
        </div>
    </div>
@endsection
