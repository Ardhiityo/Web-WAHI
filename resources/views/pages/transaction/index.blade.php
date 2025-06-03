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
                                <h5>{{ $transaction->created_at }}</h5>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <button class="btn btn-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="mx-3 btn btn-warning">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
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
                                                value="{{ $transaction->transaction_code ?? '-' }}">
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
                                <div id="logins-part" class="content" role="tabpanel"
                                    aria-labelledby="logins-part-trigger">
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
                                <form
                                    action="{{ route('transactions.update.status', ['transaction' => $transaction->id]) }}"
                                    method="post">
                                    @method('PATCH')
                                    @csrf
                                    <div id="logins-part" class="content" role="tabpanel"
                                        aria-labelledby="logins-part-trigger">
                                        <div class="form-group">
                                            <label for="voucher">Status Transaksi</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend w-100">
                                                    <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                                    <select class="form-control select2" style="width: 100%;"
                                                        name="transaction_status" required>
                                                        <option value="pending"
                                                            {{ $transaction->transaction_status == 'pending' ? 'selected' : '' }}>
                                                            Pending</option>
                                                        <option value="paid"
                                                            {{ $transaction->transaction_status == 'paid' ? 'selected' : '' }}>
                                                            Paid</option>
                                                    </select>
                                                    <button class="rounded btn btn-primary">Ubah</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div id="logins-part" class="content" role="tabpanel"
                                    aria-labelledby="logins-part-trigger">
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
        @endif
    </div>
@endsection
