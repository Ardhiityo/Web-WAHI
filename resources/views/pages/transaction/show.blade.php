@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Transaksi</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">{{ $transaction->transaction_code }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="my-2">
                <div class="mb-5 row">
                    <div class="col-6">
                        <a href="{{ route('transactions.index') }}" class="btn btn-primary" role="button">Kembali</a>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <h5>{{ $transaction->created_at->format('d/m/Y') }}</h5>
                    </div>
                </div>
                <form action="{{ route('transactions.update', ['transaction' => $transaction->id]) }}" method="post">
                    @csrf
                    @method('PUT')
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
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $transaction->user->name }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="discount_percentage">Persentase Diskon</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                        </div>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $transaction->discount_percentage ?? '0' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="discount">Diskon</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" class="form-control" readonly
                                            value="{{ number_format($transaction->discount, thousands_separator: '.') ?? '0' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="sub_total">Sub total</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" class="form-control" name="subtotal_amount"
                                            value="{{ $transaction->subtotal_amount }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="total_amount">Grand total</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" class="form-control" name="total_amount"
                                            value="{{ $transaction->total_amount }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="transaction_status">Status Transaksi</label>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="form-group">
                                    <label for="transaction_type">Jenis Pembayaran</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend w-100">
                                            <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                            <select class="form-control select2" style="width: 100%;"
                                                name="transaction_type" required>
                                                <option value="cash"
                                                    {{ $transaction->transaction_type == 'cash' ? 'selected' : '' }}>
                                                    Cash</option>
                                                <option value="cashless"
                                                    {{ $transaction->transaction_type == 'cashless' ? 'selected' : '' }}>
                                                    Cashless</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mt-4 col-12 d-flex justify-content-end">
                            <button class="btn btn-warning">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <hr>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Detail Produk</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="my-2">
                @foreach ($transaction->products as $product)
                    <form action="{{ route('product-transactions.update', ['product_transaction' => $transaction->id]) }}"
                        method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="logins-part" class="content" role="tabpanel"
                                    aria-labelledby="logins-part-trigger">
                                    <div class="form-group">
                                        <label for="name">Produk</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                            </div>
                                            <input type="text" name="name" class="form-control" readonly
                                                value="{{ $product->name }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="logins-part" class="content" role="tabpanel"
                                    aria-labelledby="logins-part-trigger">
                                    <div class="form-group">
                                        <label for="price">Harga</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</i></span>
                                            </div>
                                            <input type="text" name="price" class="form-control" readonly
                                                value="{{ $product->pivot->price }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div id="logins-part" class="content" role="tabpanel"
                                    aria-labelledby="logins-part-trigger">
                                    <div class="form-group">
                                        <label for="quantity">Quantity</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="quantity"
                                                value="{{ $product->pivot->quantity }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mt-4 col-12 d-flex justify-content-end">
                                <button class="btn btn-warning">Submit</button>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
            <hr>
        </div>
    </div>
@endsection
