<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiAdminController extends Controller
{
    public function index()
    {
        $data = transaksi::paginate(10);
        return view('admin.page.transaksi', ['title' => "Transaksi", 'name' => 'Transaksi', 'data' => $data]);
    }
    public function exportPdf(Request $request)
    {
        $dateStart  = $request->dateStart;
        $dateEnd    = $request->dateEnd;

        $data = transaksi::whereBetween('created_at', [
            $dateStart . ' 00:00:00',
            $dateEnd . ' 23:59:59'
        ])->get();

        $tanggal = Carbon::now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('admin.pdf.export-penjualan', [
        'data' => $data, 'tanggal' => $tanggal]);

        return $pdf->stream('laporan-penjualan.pdf');
    }

    public function invoice($id)
    {
        $transaksi = transaksi::with('detailTransaksi.Product')
            ->findOrFail($id);

        return view('admin.page.invoice', [
            'title'     => 'Invoice',
            'name'      => 'Invoice',
            'transaksi' => $transaksi
        ]);
    }
}
