<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            ['namamenu' => 'Nasi Goreng', 'harga' => 25000],
            ['namamenu' => 'Mie Ayam', 'harga' => 20000],
            ['namamenu' => 'Soto Ayam', 'harga' => 18000],
            ['namamenu' => 'Gado-Gado', 'harga' => 15000],
            ['namamenu' => 'Pecel Lele', 'harga' => 12000],
            ['namamenu' => 'Ayam Bakar', 'harga' => 28000],
            ['namamenu' => 'Es Teh Manis', 'harga' => 5000],
            ['namamenu' => 'Es Jeruk', 'harga' => 8000],
            ['namamenu' => 'Air Mineral', 'harga' => 3000],
            ['namamenu' => 'Teh Hangat', 'harga' => 4000],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
