@extends('pelanggan.layout.index')

@section('content')
    <style>
        input[type="number"]:: -webkit-inner-spin-button,
        input[type="number"]:: -webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    <h3 class="mt-5 mb-5">Keranjang Belanja</h3>

    @if ($data->count() > 0)

    <form action="{{ route('checkoutProduct') }}" method="POST">
        @csrf
        
        @php
            $grandTotal = 0;
        @endphp

        @foreach ($data as $x)
        <div class="card mb-3">
            <div class="card-body d-flex gap-4">

                @if ($x->product)
                    <img src="{{asset('storage/product/'. $x->product->foto)}}" width="215" height="215">

                    <div class="desc w-100">
                        <p class="fs-4 fw-bold">{{ $x->product->nama_product }}</p>
                        <p class="m-0">Stock: {{ $x->product->quantity }}</p>

                        {{-- ID BARANG --}}
                        <input type="hidden" name="idBarang[]" value="{{ $x->product->id }}">

                        {{-- HARGA --}}
                        <p class="fs-5 mt-2">
                            Harga:
                            <span>
                                Rp {{ number_format($x->product->harga,0,',','.') }}
                            </span>
                        </p>
                        <p class="m-0 text-muted" style="font-size: 12px"><span style="color: red">*</span><i>Belum termasuk PPN:11%</i></p>
                        
                        {{-- QTY --}}
                        <div class="row mb-2">
                            <label class="col-sm-2 col-form-label">Qty</label>
                            <div class="col-sm-3">
                                <input type="number"
                                    name="qty[]"
                                    class="form-control text-center qty-input"
                                    value="{{ $x->qty }}"
                                    min="1" max="{{ $x->product->quantity }}"data-harga="{{ $x->product->harga }}">
                            </div>
                        </div>

                        {{-- TOTAL --}}
                        <p class="fs-5 mt-2">
                            Total:
                            <span class="fw-bold item-total" data-total="{{ $x->product->harga * $x->qty }}">
                                Rp {{ number_format($x->product->harga * $x->qty, 0, ',', '.') }}
                            </span>
                        </p>

                        <button type="button" class="deleteData btn btn-danger" data-cart="{{ $x->id }}">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>

                    @else
                        <div class="w-100">
                            <p class="text-danger fw-bold">
                                Produk tidak ditemukan / sudah dihapus
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="card mt-4">
            <div class="card-body d-flex justify-content-between">
                <h5 class="fw-bold">Total Belanja</h5>
                <span class="fw-bold text-success" id="grand-total" style="font-size: 22px">
                    Rp 0
                </span>
            </div>
        </div>


        {{-- TOMBOL CHECKOUT SATU KALI --}}
        <button type="submit" class="btn btn-success w-100 mt-3">
            <i class="fa fa-shopping-cart"></i>
            Checkout
        </button>

        </form>
    @endif

    <script>
        function hitungGrandTotal() {
            let grandTotal = 0;

            $('.item-total').each(function () {
                grandTotal += parseInt($(this).data('total'));
            });

            $('#grand-total').text(
                'Rp ' + grandTotal.toLocaleString('id-ID')
            );
        }

        // hitung saat load
        hitungGrandTotal();

        $('.qty-input').on('input', function () {
            let harga = $(this).data('harga');
            let stok = parseInt($(this).attr('max'));
            let qty = parseInt($(this).val()) || 1;

            if (qty > stok) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Jumlah Melebihi Stok',
                    text: 'Stok tersedia hanya ' + stok,
                });

                qty = stok;
                $(this).val(stok);
            }
            
            let total = harga * qty;

            let itemTotalEl = $(this)
                .closest('.desc')
                .find('.item-total');

            itemTotalEl
                .data('total', total)
                .text('Rp ' + total.toLocaleString('id-ID'));

            hitungGrandTotal();
        });


        $('.deleteData').click(function (e) {
            e.preventDefault();

            let cartId = $(this).data('cart');

            Swal.fire({
                title: "Apakah kamu yakin?",
                text: "Barang ini akan dihapus dari keranjang!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('transaksi.delete') }}",
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}",
                            cart_id: cartId
                        },
                        success: function (res) {
                            Swal.fire({
                                title: "Berhasil!",
                                text: res.success,
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });

                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        },
                        error: function (err) {
                            Swal.fire(
                                "Gagal!",
                                "Barang tidak bisa dihapus",
                                "error"
                            );
                        }
                    });
                }
            });
        });
    </script>

@endsection
