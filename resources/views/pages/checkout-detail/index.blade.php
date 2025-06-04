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
                            <p>Selanjutnya, lanjutkan pembayaran dengan metode cashless yang tersedia, jika pembayaran
                                sukses silahkan datang ke toko untuk mengambil pesanan dengan menunjukan kode transaksi
                                .</p>
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
                        <button class="btn btn-success" id="pay-button">Bayar</button>
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
                                    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                </div>
                                <input type="text" class="rounded form-control" readonly
                                    value="{{ $transaction->discount_percentage ?? '0' }}" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dicount">Total Diskon</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control" readonly
                                    value="{{ number_format($transaction->discount, thousands_separator: '.') }}" data-mask>
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
                                    <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                </div>
                                <input type="text" class="form-control" readonly
                                    value="{{ ucfirst($transaction->transaction_type) }}" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="total_amount">Sub Total</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control" readonly
                                    value="{{ number_format($transaction->subtotal_amount, thousands_separator: '.') }}"
                                    data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="total_amount">Grand Total</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control" readonly
                                    value="{{ number_format($transaction->total_amount, thousands_separator: '.') }}"
                                    data-mask>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($transaction->transaction_type === 'cashless')
    @push('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script type="text/javascript">
            const payButton = document.getElementById('pay-button');

            function handlePayment(token) {
                snap.pay(token, {
                    onSuccess: function(result) {
                        window.location.href = '{{ route('transactions.index') }}'
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
                    const url = "{{ route('carts.checkout.snaptoken') }}";
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
