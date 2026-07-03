@extends('pelanggan.layout.index')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Detail Pemesanan</h4>
            </div>

            <div class="card-body">
                <div class="row">

                    <!-- KOLOM KIRI -->
                    <div class="col-md-6">
                        <h5>Informasi Produk</h5>

                        @foreach($detailProduk as $item)
                        <div class="d-flex mb-3 border-bottom pb-2">

                            <img src="{{ asset('storage/product/'.$item->product->foto) }}"
                                width="80"
                                height="80"
                                class="rounded me-3">

                            <div>
                                <h6>{{ $item->product->nama_product }}</h6>

                                <p class="mb-1">
                                    Qty : {{ $item->qty }}
                                </p>

                                <p class="mb-1">
                                    Rp {{ number_format($item->price) }}
                                </p>
                            </div>

                        </div>
                        @endforeach

                        <div class="border rounded p-3 bg-light">
                            <div class="d-flex justify-content-between">
                                <span>Jumlah Barang</span>
                                <span>{{ $detailProduk->count() }}</span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Total Qty</span>
                                <span>{{ $detailProduk->sum('qty') }}</span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Ongkir</span>
                                <span>Rp {{ number_format($find_data->ongkir) }}</span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <strong>Total Bayar</strong>
                                <strong class="fw-bold text-dark">
                                    Rp {{ number_format($find_data->total_harga) }}
                                </strong>
                            </div>
                        </div>    
                    </div>

                    <!-- KOLOM KANAN -->
                    <div class="col-md-6">
                        <h5>Informasi Transaksi</h5>

                        <p>
                            <strong>ID Transaksi :</strong><br>
                            {{ $find_data->code_transaksi }}
                        </p>

                        <p>
                            <strong>Nama :</strong><br>
                            {{ $find_data->nama_customer }}
                        </p>

                        <p>
                            <strong>Alamat :</strong><br>
                            {{ $find_data->alamat }},
                            {{ $find_data->kecamatan }},
                            {{ $find_data->kota }},
                            {{ $find_data->provinsi }}
                        </p>

                        <p>
                            <strong>Ekspedisi :</strong><br>
                            {{ strtoupper($find_data->ekspedisi) }}
                        </p>

                        <p>
                            <strong>Status :</strong><br>
                            <span class="badge bg-{{ $find_data->status == 'Paid' ? 'success' : 'warning' }}">
                                {{ $find_data->status }}
                            </span>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- <script type="text/javascript">
      // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{$token}}', {
            onSuccess: function(result){
                /* You may add your own implementation here */
                alert("payment success!"); console.log(result);
            },
            onPending: function(result){
                /* You may add your own implementation here */
                alert("wating your payment!"); console.log(result);
            },
            onError: function(result){
                /* You may add your own implementation here */
                alert("payment failed!"); console.log(result);
            },
            onClose: function(){
                /* You may add your own implementation here */
                alert('you closed the popup without finishing the payment');
            }
            })
        });
    </script> --}}
@endsection