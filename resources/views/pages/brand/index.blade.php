@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Brand</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-default">
        @role('owner')
            <div class="card-header">
                <h3 class="card-title">Semua brand</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
        @endrole
        <div class="card-body">
            @role('owner')
                <div class="mb-4 row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end align-items-center">
                            <a href="{{ route('brands.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            @endrole
            @if ($brands->isEmpty())
                <p>Data belum tersedia...</p>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="container overflow-auto">
                            <table class="table text-center table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No</th>
                                        <th>Brand</th>
                                        @role('owner')
                                            <th>Aksi</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <td class="align-middle">
                                                {{-- mulai 1, 11, 21, … --}}
                                                {{ $brands->firstItem() + $loop->index }}
                                            </td>
                                            <td class="align-middle">{{ $brand->name }}</td>
                                            @role('owner')
                                                <td class="align-middle text-nowrap">
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
                                            @endrole
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5 row">
                            <div class="col-12">
                                {{ $brands->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
