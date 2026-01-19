<?php

namespace App\Http\Controllers;

use App\Models\tblCart;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MidtransCallbackController extends Controller
{
    public function bayar($id)
    {
        $find_data = transaksi::find($id);

        if (!Auth::check()) {
            $countKeranjang = 0;
        } else {
            $countKeranjang = tblCart::where([
                'idUser' => Auth::id(),
                'status' => 0
            ])->count();
        }

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $find_data->code_transaksi,
                'gross_amount' => $find_data->total_harga,
            ),
            'customer_details' => array(
                'first_name' => 'Mr',
                'last_name' => $find_data->nama_customer,
                // 'email' => 'budi.pra@example.com',
                'phone' => $find_data->no_tlp,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        // dd($snapToken);die;
        return view('pelanggan.page.detailTransaksi', [
            'name' => 'Detail Transaksi',
            'title' => 'Detail Transaksi',
            'count' => $countKeranjang,
            'token' => $snapToken,
            'data' => $find_data,
        ]);
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        $hashed = hash(
            "sha512",
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        // 1. Validasi signature
        if ($hashed !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 2. Cari transaksi berdasarkan code_transaksi
        $transaksi = transaksi::where(
            'code_transaksi',
            $request->order_id
        )->first();

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        // 3. Update status sesuai Midtrans
        if (
            $request->transaction_status == 'capture' ||
            $request->transaction_status == 'settlement'
        ) {
            // update transaksi
            $transaksi->update(['status' => 'Paid']);

            // update detail transaksi
            DB::table('detail_transaksis')
                ->where('id_transaksi', $transaksi->id)
                ->update(['status' => 1]);
        }

        return response()->json(['message' => 'Callback success']);
    }


    // public function callback(Request $request)
    // {
    //     $serverKey = config('midtrans.server_key');

    //     $hashed = hash(
    //         "sha512",
    //         $request->order_id.
    //         $request->status_code.
    //         $request->gross_amount.
    //         $serverKey
    //     );

    //     if($hashed == $request->signature_key)
    //     {
    //         if($request->status == 'capture')
    //         {
    //             $find_data = transaksi::find($request->order_id);
    //             $find_data->update(['status' => 'Paid']);
    //         }
    //     }
    // }

    public function invoice($id)
    {
        $find_data = transaksi::find($id);

        if (!Auth::check()) {
            $countKeranjang = 0;
        } else {
            $countKeranjang = tblCart::where([
                'idUser' => Auth::id(),
                'status' => 0
            ])->count();
        }
        
        return view('pelanggan.page.invoice',
        [
            'title'         => 'Invoice',
            'find_data'     => $find_data,
            // compact('find_data')
            'count'         => $countKeranjang,
        ]);
    }
}
