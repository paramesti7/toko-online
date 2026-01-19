@extends('pelanggan.layout.index')

@section('content')
    <div class="row mt-4 align-items-center">
        <div class="col-md-6">
            <div class=" m-3 card-header text-center">
                <h2 class="mb-5">CONTACT US</h2>
            </div>
            <h4 class="mt-3">Toko Amalia menyediakan berbagai macam oleh-oleh khas daerah dengan kualitas terbaik dan harga terjangkau</h4>
            <hr>
            <div class="content-text" style="font-size: 20px">
                <ul class="list-unstyled">
                    <li>
                        <p>
                            Alamat : Jl. Solo-Jogja No.127
                        </p>
                    </li>
                    <li>
                        <p>No Tlp : 08123456789</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <img src="{{asset('assets/images/toko.jpeg')}}" style="width:100%;" alt="">
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