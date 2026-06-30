@extends('admin.layout.index')

@section('content')
    <div class="card rounded-full p-2">
        <div class="card-header bg-transparent d-flex justify-content-between">
            <h4>Invoice</h4>

            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>ID Transaksi :</strong> {{ $transaksi->code_transaksi }}</p>
                    <p><strong>Tanggal :</strong> {{ $transaksi->created_at }}</p>
                    <p><strong>Status :</strong> {{ $transaksi->status }}</p>
                </div>

                <div class="col-md-6">
                    <p><strong>Nama :</strong> {{ $transaksi->nama_customer }}</p>
                    <p><strong>Alamat :</strong>
                        {{ $transaksi->alamat }},
                        {{ $transaksi->kecamatan }},
                        {{ $transaksi->kota }},
                        {{ $transaksi->provinsi }}
                    </p>
                </div>
            </div>

            <hr>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi->detailTransaksi as $key => $detail)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>

                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/product/'.$detail->Product->foto) }}"
                                    alt="{{ $detail->Product->nama_product }}"
                                    width="60"
                                    height="60"
                                    class="rounded border me-2"
                                    style="object-fit: cover;">

                                <span>{{ $detail->Product->nama_product }}</span>
                            </div>
                        </td>

                        <td class="text-center">{{ $detail->qty }}</td>

                        <td class="text-end">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada detail transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">
                            Subtotal
                        </th>
                        <th class="text-end">
                            Rp {{ number_format($transaksi->total_harga - $transaksi->ongkir, 0, ',', '.') }}
                        </th>
                    </tr>

                    <tr>
                        <th colspan="3" class="text-end">
                            Ongkir
                        </th>
                        <th class="text-end">
                            {{ $transaksi->ekspedisi }}
                            (Rp {{ number_format($transaksi->ongkir, 0, ',', '.') }})
                        </th>
                    </tr>

                    <tr>
                        <th colspan="3" class="text-end">
                            Total
                        </th>
                        <th class="text-end">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection