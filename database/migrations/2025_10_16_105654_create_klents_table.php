<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('klents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->integer('order_count')->default(1);
            $table->enum('status', ['cancel', 'active', 'pedding', 'success'])->default('active');
            $table->string('start_data')->nullable();
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->string('pedding_time')->nullable();
            $table->unsignedBigInteger('currer_id')->nullable();
            $table->string('end_time')->nullable();
            $table->integer('region_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klents');
    }
};
