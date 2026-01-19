@extends('pelanggan.layout.index')

@section('content')

    <div id="error-anchor"></div>

    @if ($errors->any())
    <script>
        window.scrollTo({ top: 0, behavior: 'smooth' });
    </script>
    @endif

    {{-- @if ($errors->any())
        <div class="alert alert-danger mt-3 mb-4">
            <strong>Perhatian!</strong> Isi data lengkap terlebih dahulu.
        </div>
    @endif --}}

    <form action="{{ route('checkoutBayar') }}" method="POST" id="formCheckout">
        @csrf
        <div class="row mt-3">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <h3>Masukan Alamat Penerima</h3>
                        <div class="row mb-3">
                            <label for="nama_penerima" class="col-form-label col-sm-3">Nama Penerima</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_penerima" name="namaPenerima" placeholder="Masukan Nama Penerima" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" autofocus>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="alamat_penerima" class="col-form-label col-sm-3">Alamat Penerima</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="alamat_penerima" name="alamatPenerima" placeholder="Masukan Alamat Penerima">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tlp" class="col-form-label col-sm-3">Nomor Telpon Penerima</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="tlp" name="tlp" placeholder="Masukan Nomor Telpon Penerima" inputmode="numeric" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ekspedisi" class="col-form-label col-sm-3">Ekspedisi</label>
                            <div class="col-sm-9">
                                <select name="ekspedisi" class="form-control eksp" id="ekspedisi">
                                    <option value=""> -- Pilih Ekpedisi -- </option>
                                    <option value="jntexs">J&T Exspress</option>
                                    <option value="jnecrg">J&T Cargo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header text-center p-4">
                        <h3>Total Belanja</h3>
                    </div>
                    <div class="card-body pembayaran">
                        <h3 class="mb-3">{{ $codeTransaksi }}</h3>
                        <input type="hidden" name="code" value="{{ $codeTransaksi }}">
                        <div class="row mb-3">
                            <label for="totalBelanja" class="col-form-label col-sm-6">Total Belanja</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control totalBelanja" id="totalBelanja" name="totalBelanja" value="{{ $detailBelanja }}" readonly>
                            </div>
                        </div>
                        {{-- sunah start --}}
                        {{-- <div class="row mb-3">
                            <label for="discount" class="col-form-label col-sm-6">Discount</label>
                            <div class="col-sm-6">
                                @if (Auth::user())
                                    <input type="number" class="form-control discount" id="discount" name="discount" value="0" readonly>
                                @else
                                    <input type="number" class="form-control discount" id="discount" name="discount" value="0" readonly>
                                @endif
                            </div>
                        </div> --}}
                        {{-- sunah end --}}
                        <div class="row mb-3">
                            <label for="PPn" class="col-form-label col-sm-6">PPn</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control ppn" id="PPn" name="PPn" value="0" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="ongkir" class="col-form-label col-sm-6">Ongkir</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control ongkir" id="ongkir" name="ongkir" value="0" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label for="dibayarkan" class="col-form-label col-sm-6">Total</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control dibayarkan" id="dibayarkan" name="dibayarkan" value="0" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="dibayarkan" class="col-form-label col-sm-6">Jumlah Barang</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control dibayarkan" id="dibayarkan"
                                    name="jumlahBarang" value="{{ $jumlahbarang }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="dibayarkan" class="col-form-label col-sm-6">Total Quantity</label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control dibayarkan" id="dibayarkan" name="totalQty"
                                    value="{{ $qtyOrder }}" readonly>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fa-regular fa-money-bill-1"></i>
                            Bayar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.getElementById('formCheckout').addEventListener('submit', function (e) {
            let nama = document.getElementById('nama_penerima').value.trim();
            let alamat = document.getElementById('alamat_penerima').value.trim();
            let tlp = document.getElementById('tlp').value.trim();
            let ekspedisi = document.getElementById('ekspedisi').value;

            if (nama === '' || alamat === '' || tlp === '' || ekspedisi === '') {
                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Data belum lengkap',
                    text: 'Silakan isi data penerima terlebih dahulu',
                    confirmButtonText: 'OK'
                }).then(() => {
                    if (nama === '') {
                        document.getElementById('nama_penerima').focus();
                    } else if (alamat === '') {
                        document.getElementById('alamat_penerima').focus();
                    } else if (tlp === '') {
                        document.getElementById('tlp').focus();
                    } else if (ekspedisi === '') {
                        document.getElementById('ekspedisi').focus();
                    }
                });
            }
        });
    </script>

@endsection