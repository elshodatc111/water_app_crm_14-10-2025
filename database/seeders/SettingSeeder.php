<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SettingSeeder extends Seeder{
    public function run(): void{
        DB::table('settings')->insert([
            'water_price'     => 10000,   // suv narxi
            'idish_price'     => 30000,  // idish narxi
            'currer_price'    => 1000,  // kuryer narxi
            'sclad_price'     => 1000,   // sklad narxi
            'operator_price'  => 500,   // operator narxi
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }
}
