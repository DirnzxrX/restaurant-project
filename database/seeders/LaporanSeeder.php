<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\DetailPesanan;

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
            'namapelanggan' => 'Jibran',
            'jeniskelamin' => 1,
            'nohp' => '08123456789',
            'alamat' => 'Jl. Test No. 123'
        ]);

        $menu = Menu::create([
            'namamenu' => 'Nasi Goreng',
            'harga' => 15000
        ]);

        $pesanan = Pesanan::create([
            'idpelanggan' => $pelanggan->idpelanggan,
            'iduser' => $user->id
        ]);

        DetailPesanan::create([
            'idpesanan' => $pesanan->idpesanan,
            'idmenu' => $menu->idmenu,
            'jumlah' => 2,
        ]);

        $transaksi = Transaksi::create([
            'idpesanan' => $pesanan->idpesanan,
            'total' => 30000,
            'bayar' => 35000,
            'status' => 'lunas'
        ]);

        $pelanggan2 = Pelanggan::create([
            'namapelanggan' => 'Dewa',
            'jeniskelamin' => 0,
            'nohp' => '08123456790',
            'alamat' => 'Jl. Test No. 456'
        ]);

        $menu2 = Menu::create([
            'namamenu' => 'Mie Ayam',
            'harga' => 12000
        ]);

        $pesanan2 = Pesanan::create([
            'idpelanggan' => $pelanggan2->idpelanggan,
            'iduser' => $user->id
        ]);

        DetailPesanan::create([
            'idpesanan' => $pesanan2->idpesanan,
            'idmenu' => $menu2->idmenu,
            'jumlah' => 1,
        ]);

        echo "Sample data created successfully!\n";
    }
}
