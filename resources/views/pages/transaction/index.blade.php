@extends('layouts.app')

@section('content')
    <div class="p-2 card card-default">
        <div class="card-header">
            <h3 class="card-title">Detail Transaksi</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            @foreach ($transactions as $transaction)
                <div class="my-4">
                    <div class="mb-3 row">
                        <div class="col-6">
                            <h5>{{ $transaction->created_at }}</h5>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <button class="btn btn-primary">Produk</button>
                            <button class="mx-1 btn btn-warning">Edit</button>
                            <button class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="voucher">Kode Transaksi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $transaction->voucher->code ?? '-' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="voucher">Pemesan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $transaction->user->name }}" name="voucher">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="voucher">Persentase Diskon</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" readonly name="voucher"
                                            value="{{ $transaction->discount_percentage ?? '0' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="voucher">Diskon</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $transaction->discount ?? '0' }}" name="voucher">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="voucher">Sub total</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="voucher" readonly
                                            value="{{ $transaction->subtotal_amount }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="voucher">Grand total</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="voucher"
                                            value="{{ $transaction->total_amount }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="voucher">Status Transaksi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="voucher" readonly
                                            value="{{ $transaction->transaction_status }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="voucher">Jenis Pembayaran</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control"
                                            value="{{ $transaction->transaction_type }}" name="voucher" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>
        <div class="card-footer">
            Tunjukan Kode Transaksi kepada kasir untuk mengambil pesanan jika pembayaran berhasil.
        </div>
    </div>
@endsection
