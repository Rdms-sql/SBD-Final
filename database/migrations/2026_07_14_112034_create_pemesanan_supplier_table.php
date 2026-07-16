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
        Schema::create('pemesanan_supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_supplier')->constrained('suppliers')->cascadeOnDelete();
            $table->date('tgl_pesan');
            $table->string('status')->default('diproses'); // diproses, dikirim, selesai, batal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan_supplier');
    }
};
