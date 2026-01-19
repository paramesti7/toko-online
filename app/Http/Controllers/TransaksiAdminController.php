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
    public function exportPdf()
    {
        $data = transaksi::all();

        $tanggal = Carbon::now()->translatedFormat('d F Y');

        $pdf = Pdf::loadView('admin.pdf.export-laporan', [
        'data' => $data, 'tanggal' => $tanggal]);
        return $pdf->stream('export-laporan.pdf');
    }
}
