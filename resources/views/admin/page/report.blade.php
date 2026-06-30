@extends('admin.layout.index')

@section('content')
    <div class="d-flex flex-row justify-content-start gap-2 align-items-center">
        <div class="card">
            <div class="card-header">
                <h4 style="font-size: 16px;">Export Laporan Penjualan</h4>
            </div>

            <div class="card-body">
                <form action="{{ url('/admin/export-penjualan') }}" method="GET">
                    <div class="d-flex flex-row gap-3">
                        <div class="d-flex flex-column">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="dateStart" class="form-control" required>
                        </div>

                        <div class="d-flex flex-column">
                            <label>Tanggal Akhir</label>
                            <input type="date" name="dateEnd" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-danger mt-4">
                        Export PDF
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 style="font-size: 16px;">Export Laporan Data Produk</h4>
            </div>

            <div class="card-body">
                <form action="{{ url('/admin/export-produk') }}" method="GET">
                    <div class="d-flex flex-row gap-3">
                        <div class="d-flex flex-column">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="dateStart" class="form-control" required>
                        </div>
                        <div class="d-flex flex-column">
                            <label>Tanggal Akhir</label>
                            <input type="date" name="dateEnd" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-danger mt-4">
                        Export PDF
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection