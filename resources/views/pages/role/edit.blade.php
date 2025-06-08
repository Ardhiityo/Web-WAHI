@extends('layouts.app')

@section('content')
    <div class="mt-5 row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Peran</h3>
                </div>
                <form action="{{ route('roles.update', ['role' => $role->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputBorderWidth2">Nama</label>
                            <input type="text" name="name" required
                                class="form-control form-control-border border-width-2" id="exampleInputBorderWidth2"
                                value="{{ old('name', $role->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputBorderWidth3">Email</label>
                            <input type="email" name="email" required
                                class="form-control form-control-border border-width-2" id="exampleInputBorderWidth3"
                                value="{{ old('email', $role->email) }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleSelectBorder">Peran</label>
                            <select name="role" required class="custom-select form-control-border"
                                id="exampleSelectBorder">
                                <option value="owner"
                                    {{ old('role', $role->roles->first()->name === 'admin') ? 'selected' : '' }}>Owner
                                </option>
                                <option value="cashier"
                                    {{ old('role', $role->roles->first()->name === 'cashier') ? 'selected' : '' }}>Cashier
                                </option>
                                <option value="customer"
                                    {{ old('role', $role->roles->first()->name === 'customer') ? 'selected' : '' }}>Customer
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control form-control-border border-width-2"
                                id="password">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
