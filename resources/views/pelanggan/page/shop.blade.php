@extends('pelanggan.layout.index')

@section('content')
    <div class="d-flex flex-row gap-2 mt-4">
        {{-- sunah start --}}
        {{-- <div class="" style="width: 30%">
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    Kategori
                </div>
                <div class="card-body">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Makanan
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="d-flex flex-column gap-4">
                                        <div class="d-flex flex-row gap-3">
                                            <input type="checkbox" name="kategory" class="kategory" value="oleholeh">
                                            <span>Oleh-Oleh</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Minuman
                            </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="d-flex flex-column gap-4">
                                        <div class="d-flex flex-row gap-3">
                                            <input type="checkbox" name="kategory" class="kategory" value="oleh-oleh">
                                            <span>Oleh-Oleh</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- sunah end --}}
        <div id="productList" class="d-flex flex-wrap gap-4 mb-5" id="filterResult">
            @if ($data->isEmpty())
            <h1>Belum ada product...!</h1>
            @else
                @foreach ($data as $p)
                    <div class="card" style="width: 220px;">
                        <div class="card-header m-auto" style="height:100%;widht:100%;">
                            <img src="{{ asset('storage/product/' . $p->foto) }}" alt="barang 1" style="width: 100%;height:200px; object-fit: cover; padding:0;">
                        </div>
                        <div class="card-body">
                            <a class="product-name d-flex justify-content-between align-items-center text-decoration-none fw-semibold"
                                style="font-size: 18px; cursor:pointer;"
                                data-bs-toggle="collapse"
                                href="#descProduct{{ $p->id }}"
                                role="button"
                                aria-expanded="false"
                                aria-controls="descProduct{{ $p->id }}">
                                
                                <span>{{ $p->nama_product }}</span>
                                <i class="fa fa-chevron-down"></i>
                            </a>

                            <div class="collapse mt-2" id="descProduct{{ $p->id }}" data-bs-parent="#productList">
                                <div class="card card-body p-2" style="font-size: 13px;">
                                    {{ $p->deskripsi ?? 'Deskripsi produk belum tersedia.' }}
                                </div>
                            </div>

                            <p class="m-0 text-justify" style="font-size: 16px">Stock: {{$p->quantity}}</p>
                        </div>
                        <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                            <div class="d-flex flex-column gap-1">
                                <p class="m-0" style="font-size: 16px; font-weight:600;"><span>Rp </span> {{ number_format($p->harga,0,',','.') }}</p>
                                <p class="m-0 text-muted" style="font-size: 12px"><span style="color: red">*</span><i>Belum termasuk PPN:11%</i></p>
                            </div>

                            @if ($p->quantity > 0)
                                <form action="{{ route('addTocart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="idProduct" value="{{$p->id}}">
                                    <button class="btn btn-outline-primary" style="font-size:24px">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-outline-secondary" disabled>
                                    <i class="fa-solid fa-ban"></i>
                                </button>
                            @endif
                        </div>

                        {{-- TEKS STOK KOSONG --}}
                        @if ($p->quantity == 0)
                            <p class="badge bg-danger position-absolute" style="top:10px; right:10px;">
                                Stok Kosong
                            </p>
                        @endif
                        
                    </div>
                @endforeach
        </div>
    </div>
    <div class="pagination d-flex flex-row justify-content-between mt-3">
        <div class="showData">
            Data ditampilkan {{$data->count()}} dari {{$data->total()}}
        </div>
        <div>
            {{ $data->links() }}
        </div>
    </div>
    @endif

    {{-- Sunnah start --}}
    <script>
        $(document).ready(function() {
            $('.kategory').change(function(e) {
                e.preventDefault();
                var value = $(this).val();
                var split = value.split(' ');
                var kategory = split[0];
                var type = split[1];
                // alert(type);
                $.ajax({
                    type: "GET",
                    url: "{{ route('shop') }}",
                    data: {
                        kategory: kategory,
                        type: type,
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            });
        });
    </script>
    {{-- Sunnah end --}}
@endsection