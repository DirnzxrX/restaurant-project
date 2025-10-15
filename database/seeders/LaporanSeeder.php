<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Transaksi;
use App\Models\User;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create user if not exists
        $user = User::firstOrCreate(
            ['name' => 'admin'],
            [
                'password' => bcrypt('password'),
                'role' => 'admin',
                'namauser' => 'Administrator'
            ]
        );

        // Create sample data
        $pelanggan = Pelanggan::create([
            'namapelanggan' => 'John Doe',
            'jeniskelamin' => 1,
            'nohp' => '08123456789',
            'alamat' => 'Jl. Test No. 123'
        ]);

        $menu = Menu::create([
            'namamenu' => 'Nasi Goreng',
            'harga' => 15000
        ]);

        $pesanan = Pesanan::create([
            'idmenu' => $menu->idmenu,
            'idpelanggan' => $pelanggan->idpelanggan,
            'jumlah' => 2,
            'iduser' => $user->id
        ]);

        $transaksi = Transaksi::create([
            'idpesanan' => $pesanan->idpesanan,
            'total' => 30000,
            'bayar' => 35000,
            'status' => 'lunas'
        ]);

        // Create another sample without transaction
        $pelanggan2 = Pelanggan::create([
            'namapelanggan' => 'Jane Smith',
            'jeniskelamin' => 0,
            'nohp' => '08123456790',
            'alamat' => 'Jl. Test No. 456'
        ]);

        $menu2 = Menu::create([
            'namamenu' => 'Mie Ayam',
            'harga' => 12000
        ]);

        $pesanan2 = Pesanan::create([
            'idmenu' => $menu2->idmenu,
            'idpelanggan' => $pelanggan2->idpelanggan,
            'jumlah' => 1,
            'iduser' => $user->id
        ]);

        echo "Sample data created successfully!\n";
    }
}
