@extends('layouts.app')

@section('content')
    @hasrole('cashier')
        <h3 class="pt-5">Welcome {{ Auth::user()->roles()->first()->name }}, {{ Auth::user()->name }}</h3>
    @endhasrole
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="d-flex justify-content-end align-items-center m-3">
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary">Add data</a>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Product</th>
                                <th>Qty</th>
                                <th>Total Amount</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaction->product->name }}</td>
                                    <td>{{ $transaction->qty }}</td>
                                    <td>Rp. {{ $transaction->total_amount }}</td>
                                    <td>
                                        <a href="{{ route('transactions.edit', $transaction->id) }}"
                                            class="btn btn-primary">Edit</a>
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST"
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
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>
                </div>
            </div>


        </div>

        <!-- /.col -->
</div @endsection
