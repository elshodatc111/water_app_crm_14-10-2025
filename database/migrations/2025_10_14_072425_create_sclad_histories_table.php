<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{

    public function up(): void{
        Schema::create('sclad_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('omborchi_id')->nullable(); // User model bilan bog‘liq
            $table->unsignedBigInteger('user_id')->nullable();      // User model bilan bog‘liq
            $table->enum('type', ['currer_kirim', 'currer_chiqim', 'balans_kirim', 'balans_chiqim']);
            $table->enum('status', ['true', 'false'])->default('true');
            $table->integer('tayyor')->default(0);
            $table->integer('yarim_tayyor')->default(0);
            $table->integer('nosoz')->default(0);
            $table->integer('sotildi')->default(0);
            $table->bigInteger('summa_naqt')->default(0);
            $table->bigInteger('summa_plastik')->default(0);
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void{
        Schema::dropIfExists('sclad_histories');
    }
};
