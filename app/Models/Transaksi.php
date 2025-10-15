<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';
    protected $primaryKey = 'idtransaksi';
    public $timestamps = true;

    protected $fillable = [
        'idpesanan',
        'total',
        'bayar',
        'status',
    ];

    // Relationships
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'idpesanan');
    }

    // Accessor untuk kembalian
    public function getKembalianAttribute()
    {
        return $this->bayar - $this->total;
    }
}
