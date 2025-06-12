@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Diskon</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Semua diskon</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            @role('owner')
                <div class="row">
                    <div class="mb-4 col-12">
                        <div class="d-flex justify-content-end align-items-center">
                            <a href="{{ route('discounts.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                        </div>
                    </div>
                </div>
            @endrole
            <div class="row">
                @if ($vouchers->isEmpty())
                    <p>Data belum tersedia...</p>
                @else
                    <div class="col-12 d-flex justify-content-around">
                        <div class="container overflow-auto">
                            <table class="table text-center table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No</th>
                                        <th>Voucher</th>
                                        <th class="text-nowrap">Persentase Diskon (%)</th>
                                        @role('owner')
                                            <th>Aksi</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vouchers as $voucher)
                                        <tr>
                                            <td class="align-middle">{{ $loop->iteration }}</td>
                                            <td class="align-middle">{{ $voucher->code }}</td>
                                            <td class="align-middle">{{ $voucher->discount }}</td>
                                            @role('owner')
                                                <td class="align-middle text-nowrap">
                                                    <a href="{{ route('discounts.edit', $voucher->id) }}"
                                                        class="btn btn-warning"> <i class="fas fa-edit"></i></a>
                                                    <span class="mx-1"></span>
                                                    <form action="{{ route('discounts.destroy', $voucher->id) }}" method="POST"
                                                        style="display: inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Are you sure?')"> <i
                                                                class="fas fa-trash-alt"></i></button>
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
                                {{ $vouchers->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
