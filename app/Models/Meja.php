<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $table = 'mejas';
    protected $primaryKey = 'idmeja';
    public $timestamps = true;

    protected $fillable = [
        'nomor_meja',
        'kapasitas',
        'status',
        'keterangan',
    ];

    // Relationships
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'idmeja');
    }
}
