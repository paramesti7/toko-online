<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>
    <!-- KOP LAPORAN -->
    <div style="text-align: center; margin-bottom: 10px;">
        <h2 style="margin: 0;">LAPORAN TRANSAKSI</h2>
        <h3 style="margin: 0;">TOKO AMALIA</h3>
        <p style="margin: 5px 0; font-size: 12px;">
            Tanggal Cetak: {{ $tanggal }}
        </p>
    </div>

    <hr>

    <table class="table table-responsive table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Id Transaksi</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Nilai Trx</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $x => $item)
                <tr class="align-middle">
                    <td>{{ ++$x }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->code_transaksi }}</td>
                    <td>{{ $item->nama_customer }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->total_harga }}</td>
                    <td>
                        <span class="align-middle {{ $item->status === 'Paid' ? 'badge bg-success text-white' : 'badge bg-danger text-white' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</body>
</html>