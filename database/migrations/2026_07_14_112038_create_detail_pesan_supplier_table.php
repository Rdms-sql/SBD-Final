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
        Schema::create('detail_pesan_supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pesan_supplier')->constrained('pemesanan_supplier')->cascadeOnDelete();
            $table->foreignId('id_barang')->constrained('barangs')->cascadeOnDelete();
            $table->integer('jumlah');
            $table->unsignedBigInteger('harga_satuan');
            $table->unsignedBigInteger('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesan_supplier');
    }
};
