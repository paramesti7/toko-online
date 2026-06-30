@extends('pelanggan.layout.index')

@section('content')
    {{-- HERO + NEW PRODUCT --}}
    <div class="container-fluid p-0"
    style="margin-top:0; padding-top:75px;
        background:linear-gradient(180deg,#213555 0%,
        #2b4b72 27%,
        #dce7f4 40%,
        rgb(217, 217, 217, 0.518) 45%);">

        {{-- Container Hero --}}
        <div class="container py-5">

            <div class="row align-items-center">

                <div class="col-lg-7">

                    <span class="badge px-3 py-2 mb-3" style="background:#334155;color:#fff;">
                        🎁 Oleh-Oleh Khas & Berkualitas
                    </span>
    
                    <h2 class="text-white fw-semibold mb-2">
                        Selamat Datang di
                    </h2>
    
                    <h1 class="display-3 fw-bold" style="color:#93c5fd;">
                        TOKO AMALIA
                    </h1>
    
                    <p style="font-size:17px; line-height:1.8; color:#e2e8f0;">
                        Temukan berbagai pilihan oleh-oleh khas dengan cita rasa autentik dan
                        kualitas terbaik. Jadikan setiap perjalanan lebih berkesan dengan
                        membawa buah tangan yang istimewa untuk keluarga, teman, maupun
                        kerabat tercinta.
                    </p>
    
                    <div class="mt-4">
                        <a href="#productList" class="btn rounded-pill px-4 py-2 shadow" style="background:#2563eb; color:white;">
                            <i class="fa-solid fa-bag-shopping me-2"></i>
                            Belanja Sekarang
                        </a>
                    </div>
    
                </div>
    
                <div class="col-lg-5 text-center">
                    <img src="{{ asset('assets/images/toko.jpeg') }}"
                        class="img-fluid rounded-4 shadow-lg"
                        style="max-height:320px; object-fit:cover;">
                </div>

            </div>

        </div>


        {{-- @if ($best->count() == 0)
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
                        </div> --}}

                        {{-- TEKS STOK KOSONG --}}
                        {{-- @if ($b->quantity == 0)
                            <p class="text-danger text-center mt-2 fw-bold">
                                Stok Kosong
                            </p>
                        @endif

                    </div>
                @endforeach
            </div>
        @endif --}}

        {{-- Container New Product --}}
        <div class="container pb-5">

            <h4 class=" text-white mb-4">New Product</h4>

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

        </div>

    </div>
@endsection