@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Transaksi</h1>
                    <span>{{ $transaction->transaction_code }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">{{ $transaction->created_at->format('d/m/Y H:i') }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="my-2">
                <div class="mb-5 row">
                    <div class="col-6 d-flex align-items-center">
                        <a href="{{ route('transactions.index') }}" class="btn btn-primary" role="button">Kembali</a>
                    </div>
                    <div class="col-6 d-flex align-items-center justify-content-end">
                        <a href="{{ route('reports.export.transaction', ['transaction' => $transaction->id]) }}"
                            role="button" class="mx-2 btn btn-warning">
                            <i class="fas fa-file-download"></i>
                        </a>
                    </div>
                </div>
                <form action="{{ route('transactions.update', ['transaction' => $transaction->id]) }}" method="post">
                    @csrf
                    @method('PUT')
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
                                <label for="sub_total">Sub Total Jual</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control" name="subtotal_amount" readonly
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
                                        value="{{ $transaction->user->name }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount_percentage">Total Diskon</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control" readonly
                                        value="{{ number_format($transaction->total_discount, thousands_separator: '.') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="transaction_type">Jenis Pembayaran</label>
                                <div class="input-group">
                                    <div class="input-group-prepend w-100">
                                        <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                        @if ($transaction->transaction_status === 'pending')
                                            @if (Auth::user()->hasRole('cashier'))
                                                <select class="form-control select2" style="width: 100%;"
                                                    name="transaction_type" required>
                                                    <option value="cash"
                                                        {{ $transaction->transaction_type == 'cash' ? 'selected' : '' }}>
                                                        Cash
                                                    </option>
                                                    <option value="cashless"
                                                        {{ $transaction->transaction_type == 'cashless' ? 'selected' : '' }}>
                                                        Cashless
                                                    </option>
                                                </select>
                                            @else
                                                <input type="text" class="form-control" readonly
                                                    value="{{ ucfirst($transaction->transaction_type) }}">
                                            @endif
                                        @else
                                            <input type="hidden" class="form-control" name="transaction_type" readonly
                                                value="{{ $transaction->transaction_type }}">
                                            <input type="text" class="form-control" readonly
                                                value="{{ ucfirst($transaction->transaction_type) }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total_amount">Grand Total Jual</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" class="form-control" name="total_amount" readonly
                                        value="{{ number_format($transaction->grandtotal_selling_amount, thousands_separator: '.') }}">
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
                                        @if ($transaction->transaction_status === 'pending')
                                            @if (Auth::user()->hasRole('cashier'))
                                                <select class="form-control select2" style="width: 100%;"
                                                    name="transaction_status" required>
                                                    <option value="pending"
                                                        {{ $transaction->transaction_status == 'pending' ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="paid"
                                                        {{ $transaction->transaction_status == 'paid' ? 'selected' : '' }}>
                                                        Paid</option>
                                                    <option value="cancel"
                                                        {{ $transaction->transaction_status == 'cancel' ? 'selected' : '' }}>
                                                        Cancel</option>
                                                </select>
                                            @else
                                                <input type="text" class="form-control" readonly
                                                    value="{{ ucfirst($transaction->transaction_status) }}">
                                            @endif
                                        @else
                                            <input type="hidden" class="form-control" name="transaction_status" readonly
                                                value="{{ $transaction->transaction_status }}">
                                            <input type="text" class="form-control" readonly
                                                value="{{ ucfirst($transaction->transaction_status) }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @role('owner')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label
                                        for="total_amount">{{ $transaction->transaction_status === 'paid' ? 'Pendapatan' : 'Potensi Pendapatan' }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" class="form-control" name="total_amount" readonly
                                            value="{{ number_format($transaction->profit_amount, thousands_separator: '.') }}">
                                    </div>
                                </div>
                            </div>
                        @endrole
                    </div>
                    @role('owner')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_amount">Grand Total Modal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" class="form-control" name="total_amount" readonly
                                            value="{{ number_format($transaction->grandtotal_purchase_amount, thousands_separator: '.') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endrole
                    @hasrole('cashier')
                        @if ($transaction->transaction_status === 'pending')
                            <div class="row">
                                <div class="mt-3 col-12 d-flex justify-content-end">
                                    <button class="btn btn-warning">Update</button>
                                    @if ($transaction->transaction_type === 'cashless' && !$isPaid)
                                        <span class="mx-2"></span>
                                        <span class="btn btn-success" role="button" id="pay-button">Bayar</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endhasrole
                </form>

                @hasrole('customer')
                    @if ($transaction->transaction_status === 'pending')
                        <div class="row">
                            <div class="mt-3 col-12 d-flex justify-content-end">
                                <form action="{{ route('transactions.cancel', ['transaction' => $transaction->id]) }}"
                                    method="post">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Cancel</button>
                                </form>
                                @if ($transaction->transaction_type === 'cashless' && !$isPaid)
                                    <span class="mx-2"></span>
                                    <button class="btn btn-warning" id="pay-button">Bayar</button>
                                @endif
                            </div>
                        </div>
                    @endif
                @endhasrole

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
            @foreach ($transaction->products as $product)
                <div class="row">
                    <div class="col-12 d-flex align-items-center">
                        <h5>#{{ $loop->iteration }}</h5>
                        @if ($transaction->transaction_status === 'pending')
                            @hasrole('cashier')
                                <span class="mx-2"></span>
                                <form
                                    action="{{ route('product-transactions.destroy', ['product_transaction' => $transaction->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endhasrole
                        @endif
                    </div>
                </div>
                <div class="mt-4 mb-5">
                    <form action="{{ route('product-transactions.update', ['product_transaction' => $transaction->id]) }}"
                        method="post">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Produk</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $product->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga Jual</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</i></span>
                                        </div>
                                        <input type="text" class="form-control" readonly
                                            value="{{ number_format($product->pivot->unit_selling_price, thousands_separator: '.') }} x {{ $product->pivot->quantity }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{ $loop->iteration }}">Quantity</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-shopping-cart"></i></i></span>
                                        </div>
                                        @if (Auth::user()->hasRole('cashier'))
                                            <input type="text" class="form-control" name="quantity"
                                                value="{{ $product->pivot->quantity }}" id="{{ $loop->iteration }}"
                                                {{ $transaction->transaction_status === 'paid' || $transaction->transaction_status === 'cancel' ? 'readonly' : '' }}>
                                        @else
                                            <input type="text" class="form-control" name="quantity"
                                                value="{{ $product->pivot->quantity }}" readonly
                                                id="{{ $loop->iteration }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sub Total Jual</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</i></span>
                                        </div>
                                        <input type="text" class="form-control" readonly
                                            value="{{ number_format($product->pivot->subtotal_selling_amount, thousands_separator: '.') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                @role('owner')
                                    <div class="form-group">
                                        <label>Harga Modal</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control" readonly
                                                value="{{ number_format($product->pivot->unit_purchase_price, thousands_separator: '.') }} x {{ $product->pivot->quantity }}">
                                        </div>
                                    </div>
                                @endrole
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Total Diskon</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" class="form-control" readonly
                                            value="{{ number_format($product->pivot->total_discount, thousands_separator: '.') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                @role('owner')
                                    <div class="form-group">
                                        <label>Grand Total Modal</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control" readonly
                                                value="{{ number_format($product->pivot->grandtotal_purchase_amount, thousands_separator: '.') }}">
                                        </div>
                                    </div>
                                @endrole
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Grand Total Jual</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" class="form-control" readonly
                                            value="{{ number_format($product->pivot->grandtotal_selling_amount, thousands_separator: '.') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @role('owner')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ $transaction->transaction_status === 'paid' ? 'Pendapatan' : 'Potensi Pendapatan' }}</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control" readonly
                                                value="{{ number_format($product->pivot->profit_amount, thousands_separator: '.') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endrole
                        @if ($transaction->transaction_status === 'pending')
                            @hasrole('cashier')
                                <div class="row">
                                    <div class="mt-3 col-12 d-flex justify-content-end">
                                        <button class="btn btn-warning">Update</button>
                                    </div>
                                </div>
                            @endhasrole
                        @endif
                    </form>
                </div>
            @endforeach
            <hr>
        </div>
    </div>
@endsection

@if ($transaction->transaction_type === 'cashless' && $transaction->transaction_status === 'pending')
    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script type="text/javascript">
            const payButton = document.getElementById('pay-button');

            function handlePayment(token) {
                snap.pay(token, {
                    onSuccess: function(result) {
                        window.location.href =
                            '{!! route('transactions.show', ['transaction' => $transaction->id]) !!}'
                    },
                    onPending: function(result) {
                        alert('pending')
                    },
                    onError: function(result) {
                        alert('error')
                    }
                });
            }

            payButton.addEventListener('click', async () => {
                try {
                    const url = "{{ route('checkout.snaptoken') }}";
                    const getSnapToken = await fetch(url, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            transaction_code: "{{ $transaction->transaction_code }}"
                        })
                    });
                    const responseSnapToken = await getSnapToken.json();
                    handlePayment(responseSnapToken.token);
                } catch (error) {
                    alert(error.message);
                }
            });
        </script>
    @endpush
@endif
