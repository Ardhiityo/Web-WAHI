@extends('layouts.app')

@section('content')
    <div class="pt-5 row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Profil</h3>
                </div>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="avatar">Foto</label>
                            <input type="file" name="avatar" class="form-control form-control-border border-width-2"
                                id="avatar">
                        </div>
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" required
                                class="form-control form-control-border border-width-2" id="name"
                                value="{{ old('name', Auth::user()->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" required
                                class="form-control form-control-border border-width-2" id="email"
                                value="{{ old('email', Auth::user()->email) }}">
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
