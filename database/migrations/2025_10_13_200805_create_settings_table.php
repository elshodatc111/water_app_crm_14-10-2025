<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void{
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('water_price')->default(0);
            $table->bigInteger('idish_price')->default(0);
            $table->bigInteger('currer_price')->default(0);
            $table->bigInteger('sclad_price')->default(0);
            $table->bigInteger('operator_price')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('settings');
    }
};
