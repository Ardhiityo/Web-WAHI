@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">Laporan Penjualan</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Buat laporan</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.export.date') }}" method="get">
                <div class="row">
                    <div class="col-6">
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="form-group">
                                <label for="start_date">Dari tanggal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend w-100">
                                        <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        <select class="form-control select2" name="start_date" required id="start_date">
                                            @foreach ($dates as $date)
                                                <option value="{{ $date->created_at }}">
                                                    {{ $date->created_at->format('d/m/Y') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div id="logins-part" class="content" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="form-group">
                                <label for="end_date">Sampai tanggal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend w-100">
                                        <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                        <select class="form-control select2" name="end_date" required id="end_date">
                                            @foreach ($dates as $date)
                                                <option value="{{ $date->created_at }}">
                                                    {{ $date->created_at->format('d/m/Y') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="report_type">Format Laporan</label>
                            <select class="form-control select2" style="width: 100%;" name="report_type" required
                                id="report_type">
                                <option selected="selected" value="">Pilih...</option>
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button class="mt-4 btn btn-primary">Download</button>
            </form>
        </div>
    </div>
@endsection
