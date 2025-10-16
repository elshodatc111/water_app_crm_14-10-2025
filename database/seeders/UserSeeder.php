<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Superadmin foydalanuvchi
        User::create([
            'name' => 'Super Admin',
            'phone' => '998900000001',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'), // parolni xesh qilish shart!
            'type' => 'superadmin',
            'status' => 'true',
            'balans' => 1000000,
            'idishlar' => 0,
            'currer_balans' => 0,
        ]);

        // Admin foydalanuvchi
        User::create([
            'name' => 'Admin User',
            'phone' => '998900000002',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'type' => 'admin',
            'status' => 'true',
            'balans' => 500000,
            'idishlar' => 0,
            'currer_balans' => 0,
        ]);

        // Operator foydalanuvchi
        User::create([
            'name' => 'Operator User',
            'phone' => '998900000003',
            'email' => 'operator@example.com',
            'password' => Hash::make('password'),
            'type' => 'operator',
            'status' => 'true',
            'balans' => 200000,
            'idishlar' => 0,
            'currer_balans' => 0,
        ]);

        // Omborchi foydalanuvchi
        User::create([
            'name' => 'Omborchi User',
            'phone' => '998900000004',
            'email' => 'omborchi@example.com',
            'password' => Hash::make('password'),
            'type' => 'omborchi',
            'status' => 'true',
            'balans' => 150000,
            'idishlar' => 0,
            'currer_balans' => 0,
        ]);

        // Currer foydalanuvchi
        User::create([
            'name' => 'Currer User',
            'phone' => '998900000005',
            'email' => 'currer@example.com',
            'password' => Hash::make('password'),
            'type' => 'currer',
            'status' => 'true',
            'balans' => 50000,
            'idishlar' => 0,
            'currer_balans' => 10000,
        ]);
    }
}
