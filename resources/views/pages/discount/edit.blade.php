@extends('layouts.app')

@section('content')
    <div class="pt-5 row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit voucher</h3>
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
                <form action="{{ route('discounts.update', ['voucher' => $voucher->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="code">Kode</label>
                            <input type="text" name="code" required
                                class="form-control form-control-border border-width-2" id="code"
                                value="{{ old('code', $voucher->code) }}">
                        </div>
                        <div class="form-group">
                            <label for="discount">Diskon</label>
                            <input type="number" name="discount" required
                                class="form-control form-control-border border-width-2" id="discount"
                                value="{{ old('discount', $voucher->discount) }}">
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
