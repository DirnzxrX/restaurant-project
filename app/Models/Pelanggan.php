<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggans';
    protected $primaryKey = 'idpelanggan';
    public $timestamps = true;

    protected $fillable = [
        'namapelanggan',
        'jeniskelamin',
        'nohp',
        'alamat',
    ];

    // Relationships
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'idpelanggan');
    }

    // Accessor untuk jenis kelamin
    public function getJeniskelaminAttribute($value)
    {
        return $value ? 'Laki-laki' : 'Perempuan';
    }
}
