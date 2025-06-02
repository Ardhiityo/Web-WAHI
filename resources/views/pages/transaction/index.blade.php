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
            <form action="{{ route('carts.checkout.detail') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="form-group">
                                <label for="voucher">Kode Transaksi</label>
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
                </div>
            </form>
        </div>
        <div class="card-footer">
            Tunjukan Kode Transaksi kepada kasir untuk mengambil pesanan jika pembayaran berhasil.
        </div>
    </div>
@endsection
