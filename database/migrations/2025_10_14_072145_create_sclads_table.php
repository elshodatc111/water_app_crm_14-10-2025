<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('sclads', function (Blueprint $table) {
            $table->id();
            $table->integer('tayyor')->default(0);
            $table->integer('yarim_tayyor')->default(0);
            $table->integer('nosoz')->default(0);
            $table->bigInteger('balans_naqt')->default(0);
            $table->bigInteger('balans_plastik')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('sclads');
    }
};
