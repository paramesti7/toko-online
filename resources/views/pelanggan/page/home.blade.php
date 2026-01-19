@extends('pelanggan.layout.index')

@section('content')
    @if ($best->count() == 0)
        <div class="container"></div>
    @else
        <h4 class="mt-5">Best Seller</h4>
        <div id="productList" class="content mt-3 d-flex flex-lg-wrap gap-5 mb-5">
            @foreach ($best as $b)
                <div class="card" style="width: 220px;">
                    <div class="card-header m-auto" style="height:100%;widht:100%;">
                        <img src="{{ asset('storage/product/' . $b->foto) }}" alt="barang 1" style="width: 100%;height:200px; object-fit: cover; padding:0;">
                    </div>
                    <div class="card-body">
                        <a class="product-name d-flex justify-content-between align-items-center text-decoration-none fw-semibold"
                            style="font-size: 18px; cursor:pointer;"
                            data-bs-toggle="collapse"
                            href="#descProduct{{ $b->id }}"
                            role="button"
                            aria-expanded="false"
                            aria-controls="descProduct{{ $b->id }}">
                            
                            <span>{{ $b->nama_product }}</span>
                            <i class="fa fa-chevron-down"></i>
                        </a>

                        <div class="collapse mt-2" id="descProduct{{ $b->id }}" data-bs-parent="#productList">
                            <div class="card card-body p-2" style="font-size: 13px;">
                                {{ $b->deskripsi ?? 'Deskripsi produk belum tersedia.' }}
                            </div>
                        </div>

                        <p class="m-0 text-justify" style="font-size: 16px">Stock: {{$b->quantity}}</p>
                    </div>
                    <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                        <div class="d-flex flex-column gap-1">
                            <p class="m-0" style="font-size: 16px; font-weight:600;">
                            <span>Rp </span> {{ number_format($b->harga,0,',','.') }}</p>
                            <p class="m-0 text-muted" style="font-size: 12px"><span style="color: red">*</span><i>Belum termasuk PPN:11%</i></p>
                        </div>

                        @if ($b->quantity > 0)
                            <button class="btn btn-outline-primary" style="font-size:24px">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        @else
                            <button class="btn btn-outline-secondary" disabled>
                                <i class="fa-solid fa-ban"></i>
                            </button>
                        @endif
                    </div>

                    {{-- TEKS STOK KOSONG --}}
                    @if ($b->quantity == 0)
                        <p class="text-danger text-center mt-2 fw-bold">
                            Stok Kosong
                        </p>
                    @endif

                </div>
            @endforeach
        </div>
    @endif

    <h4 class="mt-5">New Product</h4>
    <div id="productList" class="content mt-3 d-flex flex-lg-wrap gap-5 mb-5">
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
    <div class="pagination d-flex flex-row justify-content-between mt-3">
        <div class="showData">
            Data ditampilkan {{$data->count()}} dari {{$data->total()}}
        </div>
        <div>
            {{ $data->links() }}
        </div>
    </div>
    @endif
@endsection