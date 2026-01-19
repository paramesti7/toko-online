@extends('admin.layout.index')

@section('content')
    <div class="d-flex flex-wrap gap-5">
        <div class="card" style="width: 300px;">
            <div class="card-body">
                <div class="d-flex gap-2 align-items-center justify-start">
                    <span class="material-icons p-1 rounded" style="font-size: 22px; color: green; background-color:#A6FF96">
                        inventory
                    </span>
                    <h5 class="p-0 m-0" style="color: green">Total Product</h5>
                </div>
                <span class="fs-2 p-0 m-0">{{ $totalProduct }}</span>
            </div>
        </div>
        <div class="card" style="width: 300px;">
            <div class="card-body">
                <div class="d-flex gap-2 align-items-center justify-start">
                    <span class="material-icons p-1 rounded" style="font-size: 22px; color:#D80032; background-color:#F78CA2">
                        view_in_ar
                    </span>
                    <h5 class="p-0 m-0" style="color:#D80032">Total Stock</h5>
                </div>
                <span class="fs-2 p-0 m-0">{{ $sumStock }}</span>
            </div>
        </div>
        <div class="card" style="width: 300px;">
            <div class="card-body">
                <div class="d-flex gap-2 align-items-center justify-start">
                    <span class="material-icons p-1 rounded" style="font-size: 22px; color: #088395; background-color:#7ED7C1">
                        shopping_cart
                    </span>
                    <h5 class="p-0 m-0" style="color: #088395">Transaksi</h5>
                </div>
                <span class="fs-2 p-0 m-0">{{ $dataTransaksi }}</span>
            </div>
        </div>
        <div class="card" style="width: 300px;">
            <div class="card-body">
                <div class="d-flex gap-2 align-items-center justify-start">
                    <span class="material-icons p-1 rounded" style="font-size: 22px; color:#FFC436; background-color:#F4F27E">
                        payments
                    </span>
                    <h5 class="p-0 m-0" style="color: #FFC436">Penghasilan</h5>
                </div>
                <span class="fs-2 p-0 m-0">{{ number_format($dataPenghasilan / 1000) . ' K' }}</span>
            </div>
        </div>
    </div>
@endsection