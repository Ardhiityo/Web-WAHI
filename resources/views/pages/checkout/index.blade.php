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

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Detail Pesanan</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Foto</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Quantity</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $cart)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img src="{{ asset(Storage::url($cart->product->image)) }}" width="100"
                                            height="100" alt="{{ $cart->product->name }}">
                                    </td>
                                    <td>{{ $cart->product->name }}</td>
                                    <td>{{ $cart->product->price }}</td>
                                    <td>{{ $cart->quantity }}</td>
                                    <td>
                                        <a href="{{ route('carts.edit', $cart->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('carts.destroy', $cart->id) }}" method="POST"
                                            style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5 row">
                        <div class="col-12">
                            {{ $carts->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            Visit <a href="https://select2.github.io/">Select2 documentation</a> for more examples and information
            about
            the plugin.
        </div>
    </div>
@endsection
