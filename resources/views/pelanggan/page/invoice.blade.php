@extends('pelanggan.layout.index')

@section('content')
    <div class="container mt-5">
        <div class="card w-50">
            <div class="card-header">
                <h4>Invoice</h4>
            </div>
            <div class="card-body">
                <h6>Id Transaksi {{ $find_data->code_transaksi }}</h6>
                <h6>Nama: {{ $find_data->nama_customer }}</h6>
                <h6>Total: {{ number_format($find_data->total_harga) }}</h6>
                <h6>
                    Status:
                    <span class="badge bg-{{ $find_data->status == 'Paid' ? 'success' : 'warning' }}">
                        {{ $find_data->status }}
                    </span>
                </h6>
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