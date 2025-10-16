<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScladSeeder extends Seeder{
    public function run(): void{
        DB::table('sclads')->insert([
            [
                'tayyor' => 100,
                'yarim_tayyor' => 50,
                'nosoz' => 5,
                'balans_naqt' => 2000000,
                'balans_plastik' => 1500000,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
