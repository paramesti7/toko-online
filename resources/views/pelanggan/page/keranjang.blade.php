@extends('pelanggan.layout.index')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h5>Payment List</h5>
            </div>
            <div class="card-body">
                <table class="table table-responsive table-striped">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Id Transaksi</th>
                            <th>Nama Penerima</th>
                            <th>Alamat</th>
                            <th>Total Transaksi</th>
                            <th>Status</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle text-center">
                        @foreach ($data as $x=>$item)
                            <tr>
                                <td>{{++$x}}</td>
                                <td>{{$item->code_transaksi}}</td>
                                <td>{{$item->nama_customer}}</td>
                                <td>{{$item->alamat}}, 
                                    {{$item->kecamatan}},
                                    {{$item->kota}},
                                    {{$item->provinsi}}
                                </td>
                                <td>{{$item->total_harga}}</td>
                                <td>
                                    @if ($item->status === 'Unpaid')
                                        <span class="badge text-bg-danger">Unpaid</span>
                                    @else
                                        <span class="badge text-bg-success">Paid</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status === 'Unpaid')
                                        <a href="{{ route('keranjangBayar', ['id' => $item->id]) }}" class="btn btn-success">
                                            Bayar
                                        </a>
                                    @else
                                        <a href="{{ route('invoice', ['id' => $item->id]) }}" class="btn btn-info">
                                            <i class="far fa-list-alt"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection