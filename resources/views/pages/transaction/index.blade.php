@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Transaksi</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Cari transaksi</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('transactions.index') }}" method="get">
                <div class="mb-4 row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="voucher">Kategori</label>
                            <div class="input-group">
                                <div class="input-group-prepend w-100">
                                    <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                    <select class="form-control select2" name="category" required id="category">
                                        <option value="transaction_code">Kode transaksi</option>
                                        @hasrole('owner|cashier')
                                            <option value="customer">Pemesan</option>
                                        @endhasrole
                                        <option value="transaction_type">Jenis pembayaran</option>
                                        <option value="transaction_status">Status Transaksi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="form-group">
                                <label for="keyword">Kata kunci</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="keyword">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="mt-3 ml-2 btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <div class="p-2 card card-default">
        <div class="card-header">
            <h3 class="card-title">Detail Transaksi</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        @if ($transactions->isEmpty())
            <div class="card-body">
                <p>Data belum tersedia...</p>
            </div>
        @else
            <div class="card-body">
                @foreach ($transactions as $transaction)
                    <div class="my-4">
                        <div class="mb-3 row">
                            <div class="col-6">
                                <h5>{{ $transaction->created_at->format('d/m/Y H:i') }}</h5>
                            </div>
                            <div class="col-6 d-flex align-items-center justify-content-end">
                                <a href="{{ route('reports.export.transaction', ['transaction' => $transaction->id]) }}"
                                    role="button" class="btn btn-warning">
                                    <i class="fas fa-file-download"></i>
                                </a>
                                <a href="{{ route('transactions.show', ['transaction' => $transaction->id]) }}"
                                    role="button" class="mx-3 btn btn-warning">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if ($transaction->transaction_status === 'pending' || $transaction->transaction_status === 'cancel')
                                    @hasrole('cashier')
                                        <form action="{{ route('transactions.destroy', ['transaction' => $transaction->id]) }}"
                                            method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endhasrole
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="voucher">Kode Transaksi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $transaction->transaction_code ?? '-' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="voucher">Sub total</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" class="form-control" name="voucher" readonly
                                            value="{{ number_format($transaction->subtotal_selling_amount, thousands_separator: '.') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="voucher">Pemesan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $transaction->user->name }}" name="voucher">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_discount">Total Diskon</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" class="form-control" readonly name="total_discount"
                                            value="{{ number_format($transaction->total_discount, thousands_separator: '.') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transaction_status">Status Transaksi</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend w-100">
                                            <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                            <input type="text" class="form-control" name="transaction_status" readonly
                                                value="{{ ucfirst($transaction->transaction_status) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="voucher">Grand total</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" class="form-control" name="voucher"
                                            value="{{ number_format($transaction->grandtotal_selling_amount, thousands_separator: '.') }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transaction_type">Jenis Pembayaran</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                        </div>
                                        <input type="text" class="form-control"
                                            value="{{ ucfirst($transaction->transaction_type) }}" name="transaction_type"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            @role('owner')
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="voucher">{{ $transaction->transaction_status === 'paid' ? 'Pendapatan' : 'Potensi Pendapatan' }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control" name="voucher"
                                                value="{{ number_format($transaction->profit_amount, thousands_separator: '.') }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            @endrole
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
        @endif
    </div>
@endsection
