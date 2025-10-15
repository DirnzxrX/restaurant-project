<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'namauser' => 'admin',
                'role' => 'admin',
                'password' => Hash::make('12345678')
            ],
            [
                'name' => 'Cashier',
                'namauser' => 'kasir',
                'role' => 'kasir',
                'password' => Hash::make('12345678')
            ],
            [
                'name' => 'Waiter',
                'namauser' => 'waiter',
                'role' => 'waiter',
                'password' => Hash::make('12345678')
            ],
            [
                'name' => 'Owner',
                'namauser' => 'owner',
                'role' => 'owner',
                'password' => Hash::make('12345678')
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
