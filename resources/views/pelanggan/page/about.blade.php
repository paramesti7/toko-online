@extends('pelanggan.layout.index')

@section('content')
    <div class="row mt-4 justify-content-center">
        <div class="col-md-8">
            <h3 class="text-center mb-4">Cara Belanja di Toko Amalia</h3>

            <p class="text-center">
                Belanja di <strong>Toko Amalia</strong> sangat mudah dan praktis.
                Ikuti langkah-langkah berikut untuk melakukan pemesanan:
            </p>

            <ol style="font-size: 18px; line-height: 1.8;">
                <li>
                    <strong>Pilih Produk</strong><br>
                    Pilih produk yang Anda inginkan pada halaman <em>Shop</em>.
                </li>

                <li>
                    <strong>Masukkan ke Keranjang</strong><br>
                    Klik tombol <em>Tambah ke Keranjang</em> pada produk.
                </li>

                <li>
                    <strong>Cek Keranjang</strong><br>
                    Periksa jumlah dan detail produk di halaman keranjang belanja.
                </li>

                <li>
                    <strong>Checkout</strong><br>
                    Masukkan alamat pengiriman dan pilih ekspedisi.
                </li>

                <li>
                    <strong>Lakukan Pembayaran</strong><br>
                    Selesaikan pembayaran sesuai metode yang tersedia.
                </li>

                <li>
                    <strong>Pesanan Diproses</strong><br>
                    Pesanan akan segera kami proses dan dikirim ke alamat Anda.
                </li>
            </ol>

            <p class="mt-4 text-center fw-semibold">
                Terima kasih telah berbelanja di <span class="text-primary">Toko Amaliap</span> 🙏
            </p>
        </div>
    </div>
@endsection