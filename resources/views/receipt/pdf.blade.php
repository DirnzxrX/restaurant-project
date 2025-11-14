<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk - {{ $transaksi->idtransaksi }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 0;
            padding: 20px;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
        }
        
        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .subtitle {
            font-size: 12px;
            margin-bottom: 5px;
        }
        
        .info {
            font-size: 10px;
            color: #666;
        }
        
        .section {
            margin-bottom: 15px;
        }
        
        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 2px;
        }
        
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        table th, table td {
            padding: 5px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        table td.text-right {
            text-align: right;
        }
        
        table td.text-center {
            text-align: center;
        }
        
        .total {
            border-top: 1px solid #333;
            padding-top: 5px;
            margin-top: 10px;
            font-weight: bold;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ccc;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">WARYUL</div>
        <div class="subtitle">Restaurant</div>
        <div class="info">
            Jl. Restoran No. 123, Kota<br>
            Telp: (021) 1234-5678
        </div>
    </div>

    <div class="section">
        <div class="section-title">INFORMASI TRANSAKSI</div>
        <div class="row">
            <span>No. Struk:</span>
            <span>{{ $transaksi->idtransaksi }}</span>
        </div>
        <div class="row">
            <span>Tanggal:</span>
            <span>{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="row">
            <span>Kasir:</span>
            <span>{{ $transaksi->pesanan->user->namauser ?? 'Admin' }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">DETAIL PESANAN</div>
        <div class="row">
            <span>Pelanggan:</span>
            <span>{{ $transaksi->pesanan->pelanggan->namapelanggan }}</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th class="text-center">Jumlah</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksi->pesanan->detailPesanans as $detail)
                <tr>
                    <td>{{ $detail->menu->namamenu }}</td>
                    <td class="text-center">{{ $detail->jumlah }}x</td>
                    <td class="text-right">Rp {{ number_format($detail->menu->harga, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">RINCIAN PEMBAYARAN</div>
        <div class="row">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($transaksi->pesanan->subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="row total">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
        </div>
        <div class="row">
            <span>Bayar:</span>
            <span>Rp {{ number_format($transaksi->bayar, 0, ',', '.') }}</span>
        </div>
        <div class="row">
            <span>Kembalian:</span>
            <span>Rp {{ number_format($transaksi->bayar - $transaksi->total, 0, ',', '.') }}</span>
        </div>
        <div class="row">
            <span>Status:</span>
            <span>{{ strtoupper($transaksi->status) }}</span>
        </div>
    </div>

    <div class="footer">
        <div>TERIMA KASIH</div>
        <div>Struk ini adalah bukti pembayaran yang sah</div>
    </div>
</body>
</html>
