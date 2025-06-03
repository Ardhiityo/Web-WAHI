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
            <div class="my-4">
                <form action="{{ route('transactions.update', ['transaction' => $transaction->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3 row">
                        <div class="col-6">
                            <h5>{{ $transaction->created_at }}</h5>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <a href="{{ route('transactions.index') }}" class="btn btn-primary" role="button">Kembali</a>
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
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="{{ $transaction->user->name }}"
                                             readonly>
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
                                        <input type="text" class="form-control"
                                            value="{{ $transaction->discount_percentage ?? '0' }}" readonly
                                       >
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
                                        <input type="text" class="form-control"
                                            value="{{ number_format($transaction->discount, thousands_separator: '.') ?? '0' }}"
                                            readonly>
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
                                        <input type="text" class="form-control" readonly
                                            value="{{ number_format($transaction->subtotal_amount, thousands_separator: '.') }}">
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
                                        <input type="text" class="form-control" readonly
                                            value="{{ number_format($transaction->total_amount, thousands_separator: '.') }}">
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
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                        </div>
                                        <select type="text" class="form-control" name="transaction_type" required
                                            value="{{ ucfirst($transaction->transaction_type) }}">
                                            <option value="cash"
                                                {{ old('transaction_type', $transaction->transaction_type) == 'cash' ? 'selected' : '' }}>
                                                Cash</option>
                                            <option value="cashless"
                                                {{ old('transaction_type', $transaction->transaction_type) == 'cashless' ? 'selected' : '' }}>
                                                Cashless</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mt-4 col-12">
                            <button class="btn btn-primary">Submit</button>
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
            <div class="row">
                <div class="col-12 d-flex">
                    <table class="table text-center table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Quantity</th>
                                <th>Brand</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction->products as $product)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">
                                        <img src="{{ asset(Storage::url($product->image)) }}" width="100"
                                            height="100" alt="{{ $product->name }}" class="rounded">
                                    </td>
                                    <td class="align-middle">{{ $product->name }}</td>
                                    <td class="align-middle">Rp.
                                        {{ number_format($product->pivot->price, thousands_separator: '.') }}</td>
                                    <td class="align-middle">{{ $product->pivot->quantity }}</td>
                                    <td class="align-middle">{{ $product->brand->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
