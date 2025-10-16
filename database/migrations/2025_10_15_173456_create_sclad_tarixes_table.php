<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('sclad_tarixes', function (Blueprint $table) {
            $table->id();
            $table->integer('idishlar')->default(0);
            $table->integer('nosoz_idish')->default(0);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['kirim', 'chiqim'])->default('kirim');
            $table->string('comment');
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('sclad_tarixes');
    }
};
