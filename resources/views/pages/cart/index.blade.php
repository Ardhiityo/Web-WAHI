@extends('layouts.app')

@section('content')
    <div class="mt-5 row">
        <div class="col-md-12">
            <div class="card">
                <div class="m-3 d-flex justify-content-end align-items-center">
                    <a href="{{ route('carts.checkout') }}" class="btn btn-success">Proses Pesanan</a>
                </div>
                <div class="card-body">
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
    </div>
@endsection
