@extends('pelanggan.layout.index')

@section('content')

    <div id="error-anchor"></div>

    @if ($errors->any())
    <script>
        window.scrollTo({ top: 0, behavior: 'smooth' });
    </script>
    @endif


    <form action="{{ route('checkoutBayar') }}" method="POST" id="formCheckout">
        @csrf
        <div class="row mt-3">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <h3>Masukan Alamat Tujuan</h3>
                        <div class="row mb-3">
                            <label for="nama_penerima" class="col-form-label col-sm-3">Nama Penerima</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama_penerima" name="namaPenerima" autocomplete="off" placeholder="Masukan Nama Penerima" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" autofocus>
                            </div>
                        </div>

                        <!-- Dropdown Provinsi -->
                        <div class="row mb-3">
                            <label for="province" class="col-form-label col-sm-3">Provinsi Tujuan</label>
                            <div class="col-sm-9">
                                <select name="province_id" id="province" class="form-control province">
                                    <option value=""> -- Pilih Provinsi -- </option>
                                    @foreach($provinces as $province)
                                    <option value="{{ $province['id']}}">{{ $province['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Dropdown Kota/Kabupaten -->
                        <div class="row mb-3">
                            <label for="city" class="col-form-label col-sm-3">Kota/Kabupaten Tujuan</label>
                            <div class="col-sm-9">
                                <select name="city_id" id="city" class="form-control disabled:cursor-not-allowed city">
                                    <option value=""> -- Pilih Kota/Kabupaten -- </option>
                                </select>
                            </div>
                        </div>

                        <!-- Dropdown Kecamatan -->
                        <div class="row mb-3">
                            <label for="district" class="col-form-label col-sm-3">Kecamatan Tujuan</label>
                            <div class="col-sm-9">
                                <select name="district_id" id="district" class="form-control disabled:cursor-not-allowed district">
                                    <option value=""> -- Pilih Kecamatan -- </option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="alamat_penerima" class="col-form-label col-sm-3">Alamat Tujuan</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="alamat_penerima" name="alamatPenerima" autocomplete="off" placeholder="Masukan Alamat Tujuan">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tlp" class="col-form-label col-sm-3">Nomor Telpon</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="tlp" name="tlp" autocomplete="off" placeholder="Masukan Nomor Telpon" inputmode="numeric" maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                        </div>

                        <!-- Radio Box Kurir -->
                        <div class="row mb-3">
                            <label class="col-form-label col-sm-3">Ekspedisi</label>
                            
                            <div class="col-sm-9">
                                <div class="d-flex gap-4 align-items-center">
                                    <div>
                                        <input type="radio" name="courier" id="courier-1" value="jnt">
                                        <label for="courier-1">J&T</label>
                                    </div>
    
                                    <div>
                                        <input type="radio" name="courier" id="courier-2" value="jne">
                                        <label for="courier-2">JNE</label>
                                    </div>

                                    <div>
                                        <input type="radio" name="courier" id="courier-3" value="sicepat">
                                        <label for="courier-3">SICEPAT</label>
                                    </div>
                                </div>

                                <input type="hidden" name="ekspedisi" id="ekspedisi">
                                <input type="hidden" name="service_ongkir" id="service_ongkir">
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="loader mt-4" id="loading-indicator" style="display: none;"></div>
                        </div>

                        <!-- Hasil Perhitungan Ongkos Kirim -->
                        <div class="text-center">
                            <h5 class= "mb-4">Hasil Perhitungan Ongkos Kirim</h5>
                            <div class="space-y-3" id="results-ongkir">
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
        $(document).ready(function() {

            // Fungsi formatCurrency
            function formatCurrency(amount) {
                return new Intl.NumberFormat('id-ID', {
                    style                   : 'currency',
                    currency                : 'IDR',
                    minimumFractionDigits   :0,
                    maximumFractionDigits   :0
                }).format(amount);
            }

            $('input[name="courier"]').change(function(){
                $('#ekspedisi').val($(this).val());
            });

            // Inisialisasi dropdown kota/kabupaten
            $('select[name="province_id"]').on('change', function() {
                let provinceId = $(this).val();
                if (provinceId) {
                    jQuery.ajax({
                        url: `/cities/${provinceId}`,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            $('select[name="city_id"]').empty();
                            $('select[name="city_id"]').append(`<option value="">-- Pilih Kota/Kabupaten --</option>`);
                            $.each(response, function(index, value) {
                                $('select[name="city_id"]').append(`<option value="${value.id}">${value.name}</option>`);
                            });
                        }
                    });
                } else {
                    $('select[name="city_id"]').append(`<option value="">-- Pilih Kota/Kabupaten --</option>`);
                }
            });

            // Inisialisasi dropdown kecamatan
            $('select[name="city_id"]').on('change', function() {
                let cityId = $(this).val();
                if (cityId) {
                    jQuery.ajax({
                        url: `/districts/${cityId}`,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            $('select[name="district_id"]').empty();
                            $('select[name="district_id"]').append(`<option value="">-- Pilih Kecamatan --</option>`);
                            $.each(response, function(index, value) {
                                $('select[name="district_id"]').append(`<option value="${value.id}">${value.name}</option>`);
                            });
                        }
                    });
                } else {
                    $('select[name="district_id"]').append(`<option value="">-- Pilih Kecamatan --</option>`);
                }
            });

            // ajax check ongkir
            hitungTotal();

            function hitungTotal(){

                let totalBelanja = parseInt($('#totalBelanja').val()) || 0;
                let ongkir = parseInt($('#ongkir').val()) || 0;

                let total = totalBelanja + ongkir;

                $('#dibayarkan').val(total);
            }

            $(document).on('change','input[name="pilih_ongkir"]',function(){

                let data = $(this).val().split('|');
                
                let service = data[0];
                let ongkir  = parseInt(data[1]);

                $('#service_ongkir').val(service);
                $('#ongkir').val(ongkir);

                hitungTotal();
            });

            let isProcessing = false;

            function cekOngkir() {

                if (isProcessing) return;

                let token        = $("meta[name='csrf-token']").attr("content");
                let district_id  = $('select[name=district_id]').val();
                let courier      = $('input[name=courier]:checked').val();
                let weight       = 1000;

                // Validasi form
                if (!district_id || !courier) {
                    return;
                }

                isProcessing = true;
                
                // Tampilkan loading indicator
                $('#loading-indicator').show();

                $.ajax({
                    url: "/check-ongkir",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        _token: token,
                        district_id: district_id,
                        courier: courier,
                        weight: weight,
                    },
                    success: function (response) {

                        $('#results-ongkir').empty();

                        $('.results-container').removeClass('hidden').addClass('block');

                        $.each(response, function (index, value) {

                            $('#results-ongkir').append(`
                                <div class="p-3 border rounded mb-2">
                                    <label>
                                        <input type="radio"
                                            name="pilih_ongkir"
                                            value="${value.service}|${value.cost}">
                                        ${value.service}
                                        (${value.etd} hari)
                                        - ${formatCurrency(value.cost)}
                                    </label>
                                </div>
                            `);

                        });
                        
                    },
                    complete: function () {
                        // Sembunyikan loading indicator
                        $('#loading-indicator').hide();
                        
                        // pastikan tombol bisa diklik kembali
                        isProcessing = false;
                    }
                });
            }

            $('input[name="courier"]').on('change', function(){

                $('#ekspedisi').val($(this).val());

                cekOngkir();
            });

            $('select[name="district_id"]').on('change', function(){
                cekOngkir();
            });

        });

        document.getElementById('formCheckout').addEventListener('submit', function (e) {
            let nama        = document.getElementById('nama_penerima').value.trim();
            let provinsi    = document.getElementById('province').value.trim();
            let kota        = document.getElementById('city').value.trim();
            let kecamatan   = document.getElementById('district').value.trim();
            let alamat      = document.getElementById('alamat_penerima').value.trim();
            let tlp         = document.getElementById('tlp').value.trim();
            let ekspedisi   = document.querySelector('input[name="courier"]:checked');

            if (
                nama === '' ||
                provinsi === '' ||
                kota === '' ||
                kecamatan === '' ||
                alamat === '' ||
                tlp === '' ||
                !ekspedisi
            ) {
                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Data belum lengkap',
                    text: 'Silakan isi data penerima terlebih dahulu',
                    confirmButtonText: 'OK'
                }).then(() => {
                    if (nama === '') {
                        document.getElementById('nama_penerima').focus();
                    } else if (provinsi === '') {
                        document.getElementById('province').focus();
                    }else if (kota === '') {
                        document.getElementById('city').focus();
                    }else if (kecamatan === '') {
                        document.getElementById('district').focus();
                    }else if (alamat === '') {
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