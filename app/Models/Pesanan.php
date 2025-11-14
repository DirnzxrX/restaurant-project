<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';
    protected $primaryKey = 'idpesanan';
    public $timestamps = true;

    protected $fillable = [
        'idpelanggan',
        'iduser',
    ];

    // Relationships
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'idpesanan');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'idpelanggan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'iduser');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'idpesanan');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'idpesanan');
    }

    // Accessor untuk subtotal (total dari semua detail pesanan)
    public function getSubtotalAttribute()
    {
        return $this->detailPesanans->sum(function($detail) {
            return $detail->menu->harga * $detail->jumlah;
        });
    }
}
