@extends('layouts.app')

@section('content')
    <div class="mt-5 row">
        <div class="col-md-12">
            <div class="card">
                <div class="m-3 d-flex justify-content-end align-items-center">
                    <a href="{{ route('vouchers.create') }}" class="btn btn-primary">Tambah</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Kode</th>
                                <th>Diskon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vouchers as $voucher)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $voucher->code }}</td>
                                    <td>{{ $voucher->discount }}%</td>
                                    <td>
                                        <a href="{{ route('vouchers.edit', $voucher->id) }}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST"
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
                            {{ $vouchers->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- /.col -->
</div @endsection
