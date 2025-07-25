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
                        <div class="form-group">
                            <label for="transaction_type">Tipe Pembayaran</label>
                            <select class="form-control select2" style="width: 100%;" name="transaction_type" required
                                id="transaction_type">
                                <option selected="selected" value="">Pilih...</option>
                                <option value="cash">Cash</option>
                                <option value="cashless">Cashless</option>
                            </select>
                        </div>
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
