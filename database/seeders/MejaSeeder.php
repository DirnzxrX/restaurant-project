<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mejas = [
            [
                'nomor_meja' => 'A1',
                'kapasitas' => 2,
                'status' => 'tersedia',
                'keterangan' => 'Meja untuk 2 orang, dekat jendela'
            ],
            [
                'nomor_meja' => 'A2',
                'kapasitas' => 4,
                'status' => 'tersedia',
                'keterangan' => 'Meja untuk 4 orang, area tengah'
            ],
            [
                'nomor_meja' => 'A3',
                'kapasitas' => 6,
                'status' => 'tersedia',
                'keterangan' => 'Meja untuk 6 orang, area keluarga'
            ],
            [
                'nomor_meja' => 'B1',
                'kapasitas' => 2,
                'status' => 'terisi',
                'keterangan' => 'Meja untuk 2 orang, area VIP'
            ],
            [
                'nomor_meja' => 'B2',
                'kapasitas' => 4,
                'status' => 'reserved',
                'keterangan' => 'Meja untuk 4 orang, reserved untuk acara'
            ],
            [
                'nomor_meja' => 'C1',
                'kapasitas' => 8,
                'status' => 'tersedia',
                'keterangan' => 'Meja besar untuk 8 orang, area grup'
            ],
        ];

        foreach ($mejas as $meja) {
            \App\Models\Meja::create($meja);
        }
    }
}
