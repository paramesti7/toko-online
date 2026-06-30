@extends('admin.layout.index')

@section('content')
    <div class="card rounded-full p-2">
        {{-- <div class="card-header bg-transparent d-flex justify-content-between"> --}}
            {{-- <a href="/admin/export-pdf" class="btn btn-danger">Export PDF</a> --}}
            {{-- <button class="btn btn-danger" id="addData">
                <i class="fa fa-plus">
                    <span>View PDF</span>
                </i>
            </button> --}}
            {{-- <input type="text" wire:model="search" class="form-control w-25" placeholder="search..."> --}}
        {{-- </div> --}}
        
        <div class="card-body">
            <table class="table table-responsive table-striped">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Date</th>
                        <th>Id Transaksi</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Nilai Trx</th>
                        <th>Status</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $x => $item)
                        <tr class="align-middle">
                            <td>{{ ++$x }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->code_transaksi }}</td>
                            <td>{{ $item->nama_customer }}</td>
                            <td>{{ $item->alamat }}, 
                                {{ $item->kecamatan }},
                                {{ $item->kota }},
                                {{ $item->provinsi }}
                            </td>
                            <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="align-middle {{ $item->status === 'Paid' ? 'badge bg-success text-white' : 'badge bg-danger text-white' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.invoice', ['id' => $item->id]) }}" class="btn btn-info">
                                    <i class="far fa-list-alt"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination d-flex flex-row justify-content-between">
                <div class="showData">
                    Data ditampilkan {{ $data->count() }} dari {{ $data->total() }}
                </div>
                <div>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection