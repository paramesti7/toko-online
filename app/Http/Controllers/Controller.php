<?php

namespace App\Http\Controllers;

use App\Models\modelDetailTransaksi;
use App\Models\Product;
use App\Models\tblCart;
use App\Models\transaksi;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function shop(Request $request)//ini request tadi enggak ada
    {
        // $data = Product::paginate(8); ini originalnya

        // Sunnah Start
        if ($request->has('kategory') && $request->has('type')) {
            $category = $request->input('kategory');
            $type = $request->input('type');
            $data = product::where('kategory', $category)
                ->orWhere('type', $type)->paginate(5);
        } else {
            $data = product::paginate(5);
        }
        // Sunnah End
        if (!Auth::check()) {
            $countKeranjang = 0;
        } else {
            $countKeranjang = tblCart::where([
                'idUser' => Auth::id(),
                'status' => 0
            ])->count();
        }

        return view('pelanggan.page.shop',[
            'title'     => 'Shop',
            'data'      => $data,
            'count'     => $countKeranjang,
        ]);
    }
    public function transaksi()
    {
        $db = tblCart::with('product')->where(['idUser' => Auth::id(), 'status' => 0])->get();

        if (!Auth::check()) {
            $countKeranjang = 0;
        } else {
            $countKeranjang = tblCart::where([
                'idUser' => Auth::id(),
                'status' => 0
            ])->count();
        }

        return view('pelanggan.page.transaksi',[
            'title' => 'Transaksi',
            'count' => $countKeranjang,
            'data'  => $db,
        ]);
    }

    public function contact()
    {
        if (!Auth::check()) {
            $countKeranjang = 0;
        } else {
            $countKeranjang = tblCart::where([
                'idUser' => Auth::id(),
                'status' => 0
            ])->count();
        }

        return view('pelanggan.page.contact',[
            'title' => 'Contact Us',
            'count' => $countKeranjang,
        ]);
    }

    public function about()
    {
        if (!Auth::check()) {
            $countKeranjang = 0;
        } else {
            $countKeranjang = tblCart::where([
                'idUser' => Auth::id(),
                'status' => 0
            ])->count();
        }

        return view('pelanggan.page.about', [
            'title' => 'About',
            'count' => $countKeranjang
        ]);
    }

    public function checkout()
    {
        if (!Auth::check()) {
            $countKeranjang = 0;
        } else {
            $countKeranjang = tblCart::where([
                'idUser' => Auth::id(),
                'status' => 0
            ])->count();
        }

        // mengambil data provinsi dari API Raja Ongkir
        $response = Http::withHeaders([

            // headers yang diperlukan untuk API Raja Ongkir
            'Accept'=> 'application/json',
            'key'   => config('rajaongkir.api_key'),

        ])-> get('https://rajaongkir.komerce.id/api/v1/destination/province');

        $provinces = [];

        if ($response->successful()) {
            $provinces = $response->json()['data'] ?? [];
        }

        $code = transaksi::count();
        $codeTransaksi = date('Ymd') . ($code + 1);
        $detailBelanja = modelDetailTransaksi::where(['id_transaksi' => $codeTransaksi, 'status' => 0])->sum('price');
        $jumlahBarang = modelDetailTransaksi::where(['id_transaksi' => $codeTransaksi, 'status' => 0])->count('id_barang');
        $qtyBarang = modelDetailTransaksi::where(['id_transaksi' => $codeTransaksi, 'status' => 0])->sum('qty');

        return view('pelanggan.page.checkOut',[
            'title'         => 'Check Out',
            'count'         => $countKeranjang,
            'detailBelanja' => $detailBelanja,
            'jumlahbarang'  => $jumlahBarang,
            'qtyOrder'      => $qtyBarang,
            'codeTransaksi' => $codeTransaksi,
            'provinces'     => $provinces,
        ]);
    }

    /**
     * Mengambil data kota berdasarkan ID provinsi
     *
     * @param int $provinceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCities($provinceId)
    {
        // mengambil data kota bedasarkan ID provinsi dari API Raja Ongkir
        $response = Http::withHeaders([

            // headers yang diperlukan untuk API Raja Ongkir
            'Accept' => 'application/json',
            'key'    => config('rajaongkir.api_key'),

        ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$provinceId}");

        if ($response->successful()) {

            // mengambil data kota dari respons JSON
            // jika 'data' tidak ada, inisialisasi dengan array kosong
            return response()->json($response->json()['data'] ?? []);
        }
    }

    /**
     * Mengambil data kecamatan berdasarkan ID kota
     *
     * @param int $cityId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistricts($cityId)
    {
        // Mengambil data kecamatan berdasarkan ID kota dari API Raja Ongkir
        $response = Http::withHeaders([

            //headers yang diperlukan untuk API Raja Ongkir
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),

        ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$cityId}");

        if ($response->successful()) {

            // Mengambil data kecamatan dari respons JSON
            // Jika 'data' tidak ada, inisialisasi dengan array kosong
            return response()->json($response->json()['data'] ?? []);
        }
    }

    /**
     * Menghitung ongkos kirim berdasarkan data yang diberikan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function checkOngkir(Request $request)
    {
        $response = Http::asForm()->withHeaders([

            //headers yang diperlukan untuk API Raja Ongkir
            'Accept' => 'application/json',
            'key'    => config('rajaongkir.api_key'),

        ])->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'origin'      => 5317,
                'destination' => $request->input('district_id'), // ID kecamatan tujuan
                'weight'      => 1000, // Berat dalam gram
                'courier'     => $request->input('courier'), // Kode kurir (jne, tiki, pos)
        ]);

        if ($response->successful()) {

            // Mengambil data ongkos kirim dari respons JSON
            // Jika 'data' tidak ada, inisialisasi dengan array kosong
            return $response->json()['data'] ?? [];
        }
    }

    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'idBarang' => 'required|array',
            'qty'      => 'required|array',
        ]);

        $idBarang = $request->idBarang;
        $qty      = $request->qty;

         // VALIDASI STOK SEBELUM CHECKOUT
        foreach ($idBarang as $index => $id) {
            $product = Product::find($id);

            if (!$product) {
                Alert::error('Gagal', 'Produk tidak ditemukan');
                return back();
            }

            if ($qty[$index] > $product->quantity) {
                Alert::error(
                    'Gagal Checkout',
                    'Jumlah "' . $product->nama_product . '" melebihi stok tersedia (' . $product->quantity . ')'
                );
                return back();
            }
        }

        // =============================
        // LANJUT PROSES CHECKOUT
        // =============================

        $code = transaksi::count() + 1;
        $codeTransaksi = date('Ymd') . $code;

        foreach ($idBarang as $index => $id) {

            // ambil data produk
            $product = Product::findOrFail($id);
            $qtyBarang = (int) $qty[$index];

            // hitung total yang BENAR
            $totalHarga = $product->harga * $qtyBarang;

            // simpan detail transaksi
            modelDetailTransaksi::create([
                'id_transaksi' => $codeTransaksi,
                'id_barang'    => $id,
                'qty'          => $qtyBarang,
                'price'        => $totalHarga,
                'status'       => 0
            ]);

            
            tblCart::where('id_barang', $id)
                ->where('idUser', (string) Auth::id())
                ->where('status', 0)
                ->update(['status' => 1]);
        }

        Alert::success('Checkout Berhasil', 'Silakan lanjut ke pembayaran');

        return redirect()->route('checkout');
    }
    
    public function prosesPembayaran(Request $request)
    {
        $request->validate([
            'namaPenerima'     => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'alamatPenerima'   => ['required'],
            'tlp'              => ['required', 'digits_between:10,15'],
            'ekspedisi'        => ['required'],
            'province_id'      => ['required'],
            'city_id'          => ['required'],
            'district_id'      => ['required'],
        ], [
            'required' => 'Isi data lengkap terlebih dahulu',
            'namaPenerima.regex' => 'Nama penerima tidak boleh mengandung angka',
            'tlp.digits_between' => 'Nomor telepon harus 10–15 digit angka',
        ]);

        $data = $request->all();
        $dbTransaksi = new transaksi();

        $dbTransaksi->idUser            = Auth::id();
        $dbTransaksi->code_transaksi    = $data['code'];
        $dbTransaksi->total_qty         = $data['totalQty'];
        $dbTransaksi->total_harga       = $data['dibayarkan'];
        $dbTransaksi->nama_customer     = $data['namaPenerima'];
        $dbTransaksi->alamat            = $data['alamatPenerima'];
        $dbTransaksi->no_tlp            = $data['tlp'];
        $dbTransaksi->ekspedisi         = $data['ekspedisi'];
        $dbTransaksi->provinsi          = $data['province_id'];
        $dbTransaksi->kota              = $data['city_id'];
        $dbTransaksi->kecamatan         = $data['district_id'];
        
        $dbTransaksi->save();

        $dataCart = modelDetailTransaksi::where('id_transaksi', $data['code'])->get();
        foreach ($dataCart as $x) {
            $dataUp = modelDetailTransaksi::where('id',$x->id)->first();
            $dataUp->status = 1;
            $dataUp->save();

            $idProduct = Product::find($x->id_barang);

            if ($idProduct) {
                $idProduct->quantity -= $x->qty;
                $idProduct->quantity_out = $x->qty;
                $idProduct->save();
            }
        }

        Alert::alert()->success('Transaksi Berhasil', 'Silakan lakukan pembayaran');

        return redirect()->route('keranjang');
    }

    public function keranjang()
    {
        if (!Auth::check()) {
            $countKeranjang = 0;
            $all_trx = collect(); // kosong jika belum login
        } else {
            $countKeranjang = tblCart::where([
                'idUser' => Auth::id(),
                'status' => 0
            ])->count();

            $all_trx = transaksi::where('idUser', Auth::id())->get();
        }
        // $all_trx = transaksi::all();
        return view('pelanggan.page.keranjang',[
            'name'  => 'Payment',
            'title' => 'Payment Process',
            'count' => $countKeranjang,
            'data'  => $all_trx,
        ]);
    }

    // public function bayar($id)

    public function admin()
    {
        $dataProduct = Product::count();
        $dataStock = Product::sum('quantity');
        $dataTransaksi = transaksi::count();
        $dataPenghasilan = transaksi::sum('total_harga');
        return view('admin.page.dashboard',[
            'name'              => "Dasboard",
            'title'             => 'Admin Dashboard',
            'totalProduct'      => $dataProduct,
            'sumStock'          => $dataStock,
            'dataTransaksi'     => $dataTransaksi,
            'dataPenghasilan'   => $dataPenghasilan,
        ]);
    }

    public function userManagement()
    {
        return view('admin.page.user',[
            'name'  => "User Management",
            'title' => 'Admin User Management',
        ]);
    }
    public function report()
    {
        return view('admin.page.report',[
            'name'  => "Report",
            'title' => 'Admin Report',
        ]);
    }
    public function login()
    {
        return view('admin.page.login',[
            'name'  => "Login",
            'title' => 'Admin Login',
        ]);
    }

    public function loginProses(Request $request)
    {
        // Session::flash('error', $request->email);

        // $dataLogin = [
        //     'email'     => $request->email,
        //     'password'  => $request->password,
        // ];

        // =============================
        // 1. VALIDASI FORM
        // =============================
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:3'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 3 karakter',
        ]);

        // $user = new User;
        // $proses = $user::where('email',$request->email)->first();

        // =============================
        // 2. CEK USER TERDAFTAR
        // =============================
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Alert::toast('Akun tidak ditemukan', 'error');
            return back()->withInput();
        }

        // =============================
        // 3. CEK ROLE ADMIN
        // =============================
        if ($user->is_admin != 1) {
            Alert::toast('Kamu bukan admin', 'error');
            return back()->withInput();
        }

        // =============================
        // 4. PROSES LOGIN (GUARD ADMIN)
        // =============================

        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {

            // WAJIB: regenerate session (ANTI 419)
            $request->session()->regenerate();

            Alert::toast('Kamu berhasil login', 'success');
            return redirect()->route('admin.dashboard');
        }

        // =============================
        // 5. PASSWORD SALAH
        // =============================
        Alert::toast('Email dan Password salah', 'error');
        return back()->withInput();
        
        // if(optional($proses)->is_admin === 0){
        //     Session::flash('error','Kamu bukan admin');
        //     return back();
        // }else{
        //     if (Auth::attempt($dataLogin)) {
        //         Alert::toast('Kamu berhasil login', 'success');
        //         $request->session()->regenerate();
        //         return redirect()->intended('/admin/dashboard');
        //     }else {
        //         Alert::toast('Email dan Password salah', 'error');
        //         return back();
        //     }
        // }
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        Alert::toast('Kamu berhasil logout', 'success');
        return redirect('/admin');
    }
}
