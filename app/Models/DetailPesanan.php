<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanans';
    protected $primaryKey = 'iddetailpesanan';
    public $timestamps = true;

    protected $fillable = [
        'idpesanan',
        'idmenu',
        'jumlah',
    ];

    // Relationships
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'idpesanan');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idmenu');
    }

    // Accessor untuk subtotal
    public function getSubtotalAttribute()
    {
        return $this->menu->harga * $this->jumlah;
    }
}
