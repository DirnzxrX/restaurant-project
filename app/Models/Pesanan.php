<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';
    protected $primaryKey = 'idpesanan';
    public $timestamps = true;

    protected $fillable = [
        'idmenu',
        'idpelanggan',
        'jumlah',
        'iduser',
    ];

    // Relationships
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idmenu');
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

    // Accessor untuk subtotal
    public function getSubtotalAttribute()
    {
        return $this->menu->harga * $this->jumlah;
    }
}
