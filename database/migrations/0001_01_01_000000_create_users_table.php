<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('type', ['superadmin', 'admin', 'operator', 'omborchi', 'currer'])->default('currer');
            $table->enum('status', ['true', 'false', 'delete'])->default('true');
            $table->bigInteger('balans')->default(0);
            $table->bigInteger('currer_balans')->default(0);
            $table->bigInteger('idishlar')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void{
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
