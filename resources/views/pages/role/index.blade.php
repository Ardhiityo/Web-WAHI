@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">Daftar Peran</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Semua peran</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="mb-4 col-12">
                    <div class="d-flex justify-content-end align-items-center">
                        <a href="{{ route('roles.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="container overflow-auto">
                        <table class="table text-center table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Peran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="align-middle">
                                            {{-- mulai 1, 11, 21, … --}}
                                            {{ $users->firstItem() + $loop->index }}
                                        </td>
                                        <td class="align-middle">{{ $user->name }}</td>
                                        <td class="align-middle">{{ $user->email }}</td>
                                        <td class="align-middle">{{ ucfirst($user->roles->pluck('name')->implode(', ')) }}
                                        </td>
                                        <td class="align-middle text-nowrap">
                                            <a href="{{ route('roles.edit', $user->id) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <span class="mx-1"></span>
                                            <form action="{{ route('roles.destroy', $user->id) }}" method="POST"
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
                    </div>
                    <div class="mt-5 row">
                        <div class="col-12">
                            {{ $users->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
