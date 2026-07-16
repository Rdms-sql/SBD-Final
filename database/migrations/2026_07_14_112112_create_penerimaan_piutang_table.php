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
        Schema::create('penerimaan_piutang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_piutang')->constrained('piutang')->cascadeOnDelete();
            $table->date('tgl_terima');
            $table->unsignedBigInteger('jumlah_terima');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan_piutang');
    }
};
