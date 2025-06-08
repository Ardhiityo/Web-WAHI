@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">Proses Transaksi</h1>
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
            <form action="{{ route('transactions.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="form-group">
                                <label for="voucher">Punya Voucher?</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Masukan Kode Voucher"
                                        name="voucher" data-mask>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="form-group">
                                <label for="transaction_type">Tipe Pembayaran</label>
                                <select class="form-control select2" style="width: 100%;" name="transaction_type" required
                                    id="transaction_type">
                                    <option selected="selected" value="">Pilih...</option>
                                    <option value="cash">Cash</option>
                                    <option value="cashless">Cashless</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-success">Buat Pesanan</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            Tunjukan Kode Transaksi kepada kasir untuk mengambil pesanan jika pembayaran berhasil.
        </div>
    </div>
@endsection
