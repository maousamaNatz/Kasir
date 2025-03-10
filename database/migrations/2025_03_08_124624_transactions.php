<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();
            $table->foreignId('user_id')->constrained(); // Kasir
            $table->decimal('total', 15, 2);
            $table->decimal('bayar', 15, 2);
            $table->decimal('kembali', 15, 2);
            $table->enum('metode_pembayaran', ['tunai'])->default('tunai');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->timestamp('waktu_transaksi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
