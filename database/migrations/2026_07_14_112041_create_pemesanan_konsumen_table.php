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
        Schema::create('pemesanan_konsumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_konsumen')->constrained('konsumens')->cascadeOnDelete();
            $table->date('tgl_pesan');
            $table->string('status')->default('diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan_konsumen');
    }
};
