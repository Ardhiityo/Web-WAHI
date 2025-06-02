@extends('layouts.app')

@section('content')
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Daftar Produk</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-4 row">
                <div class="col-12">
                    <div class="d-flex justify-content-end align-items-center">
                        <a href="{{ route('brands.create') }}" class="btn btn-primary">Tambah</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-around">
                    <table class="table text-center table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Brand</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>
                                        <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <span class="mx-1"></span>
                                        <form action="{{ route('brands.destroy', $brand->id) }}" method="POST"
                                            style="display: inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-5 row">
                        <div class="col-12">
                            {{ $brands->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            Semua daftar brand
        </div>
    </div>
@endsection
