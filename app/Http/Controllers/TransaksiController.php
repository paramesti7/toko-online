<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use App\Http\Requests\StoretransaksiRequest;
use App\Http\Requests\UpdatetransaksiRequest;
use App\Models\Product;
use App\Models\tblCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $best = Product::where('quantity_out','>=',5)->get();
        $data = Product::paginate(15);
        
        if (!Auth::check()) {
            $countKeranjang = 0;
        } else {
            $countKeranjang = tblCart::where([
                'idUser' => Auth::id(),
                'status' => 0
            ])->count();
        }

        return view('pelanggan.page.home',[
            'title'     => 'Home',
            'data'      => $data,
            'best'      => $best,
            'count'     => $countKeranjang,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addTocart(Request $request)
    {
        // Ambil produk (jika tidak ada → 404)
        $product = Product::findOrFail($request->idProduct);

        // Cek stok kosong
        if ($product->quantity <= 0) {
            Alert::error('Gagal', 'Stok produk kosong');
            return back();
        }

        // Cek apakah produk sudah ada di keranjang user
        $cart = tblCart::where([
            'idUser'    => Auth::id(),
            'id_barang' => $product->id,
            'status'    => 0
        ])->first();

        if ($cart) {
            // Jika qty di keranjang sudah sama dengan stok
            if ($cart->qty >= $product->quantity) {
                Alert::warning('Perhatian', 'Jumlah melebihi stok tersedia');
                return back();
            }

            // Tambah qty
            $cart->qty += 1;
            $cart->price = $cart->qty * $product->harga;
            $cart->save();

            Alert::success('Berhasil', 'Jumlah produk ditambahkan');
        } else {
            // Jika belum ada di keranjang
            tblCart::create([
                'idUser'    => Auth::id(),
                'id_barang' => $product->id,
                'qty'       => 1,
                'price'     => $product->harga,
                'status'    => 0
            ]);

            Alert::success('Berhasil', 'Produk ditambahkan ke keranjang');
        }

        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretransaksiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetransaksiRequest $request, transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        tblCart::where([
            'id'     => $request->cart_id,
            'idUser' => Auth::id(),
            'status' => 0
        ])->delete();

        return response()->json([
            'success' => 'Barang berhasil dihapus'
        ]);
    }
}


