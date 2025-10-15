<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #c8e6c9; }
        h2 { text-align: center; margin-bottom: 0; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $trx)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $trx->pesanan->pelanggan->namapelanggan ?? '-' }}</td>
                    <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($trx->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total:</strong> Rp {{ number_format($total, 0, ',', '.') }}</p>
</body>
</html>
