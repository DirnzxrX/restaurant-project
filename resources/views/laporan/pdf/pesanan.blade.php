<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pesanan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #bbdefb; }
        h2 { text-align: center; margin-bottom: 0; }
    </style>
</head>
<body>
    <h2>Laporan Pesanan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Items</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanans as $psn)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $psn->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $psn->pelanggan->namapelanggan ?? '-' }}</td>
                    <td>
                        @if($psn->detailPesanans->count() > 0)
                            @foreach($psn->detailPesanans as $detail)
                                • {{ $detail->menu->namamenu ?? '-' }} ({{ $detail->jumlah }}x) - Rp {{ number_format($detail->subtotal, 0, ',', '.') }}<br>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td>Rp {{ number_format($psn->subtotal, 0, ',', '.') }}</td>
                    <td>{{ $psn->transaksi ? 'Sudah Bayar' : 'Belum Bayar' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
