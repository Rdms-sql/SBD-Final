<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemesanan_konsumen', function (Blueprint $table) {
            $table->foreignId('id_penjualan')->nullable()->after('status')->constrained('penjualan')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pemesanan_konsumen', function (Blueprint $table) {
            $table->dropForeign(['id_penjualan']);
            $table->dropColumn('id_penjualan');
        });
    }
};
