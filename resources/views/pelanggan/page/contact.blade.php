@extends('pelanggan.layout.index')

@section('content')
    <div class="container py-5">
        <div class="row align-items-center">

            <div class="col-md-6">
                <img src="{{ asset('assets/images/toko.jpeg') }}"
                    class="img-fluid contact-image"
                    alt="Toko Amalia">
            </div>

            <div class="col-md-6">

                <h1 class="fw-bold mb-4">
                    Toko Amalia
                </h1>

                <p class="text-secondary fs-5 mb-4">
                    Toko Amalia menyediakan berbagai macam oleh-oleh khas daerah
                    dengan kualitas terbaik dan harga terjangkau.
                </p>

                <div class="shadow-sm p-3 rounded-4 mb-3 bg-white">
                    <i class="fas fa-map-marker-alt text-danger"></i>
                    JL. Solo - Jogja No.127
                </div>

                <div class="shadow-sm p-3 rounded-4 mb-4 bg-white">
                    <i class="fas fa-phone-alt text-success"></i>
                    08123456789
                </div>

                {{-- <a href="#" class="btn btn-primary px-4 py-2 rounded-pill">
                    Hubungi Sekarang
                </a> --}}
            </div>

        </div>


        {{-- sunah start --}}
        {{-- <div class="d-flex justify-content-lg-between mt-5">
            <div class="d-flex align-items-center gap-4">
                <i class="fa fa-users fa-2x"></i>
                <p class="m-0 fs-5">+ 300 Pelanggan</p>
            </div>
            <div class="d-flex align-items-center gap-4">
                <i class="fas fa-home fa-2x"></i>
                <p class="m-0 fs-5">+ 300 Seller</p>
            </div>
            <div class="d-flex align-items-center gap-4">
                <i class="fas fa-shirt fa-2x"></i>
                <p class="m-0 fs-5">+ 300 Product</p>
            </div>
        </div>

        <h4 class="text-center mt-md-5 mb-md-2">Contact Us</h4>
        <hr class="mb-5">
        <div class="row mb-md-5">
            <div class="col-md-5">
                <div class="bg-secondary" style="width: 100%; height:50vh; border-radius:10px;"></div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Kritik dan Saran</h4>
                    </div>
                    <div class="card-body">
                        <p class="p-0 mb-5 text-lg-left">Masukan kritik dan saran anda kepada website kami agar kami dapat memberikan apa yang menjadi kebutuhan anda dan kami dapat berkembang lebih baik lagi.</p>
                        <div class="mb-3 row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" value="" placeholder="Masukan Email Anda">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="pesan" placeholder="Masukan Password Anda">
                            </div>
                        </div>
                        <button class="btn btn-primary mt-4 w-100">Kirim pesan anda</button>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- sunah end --}}
    </div>
@endsection