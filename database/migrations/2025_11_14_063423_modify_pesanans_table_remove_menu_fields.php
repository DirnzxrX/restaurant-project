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
        Schema::table('pesanans', function (Blueprint $table) {
            // Hapus foreign key constraint dulu
            $table->dropForeign(['idmenu']);
            // Hapus kolom idmenu dan jumlah
            $table->dropColumn(['idmenu', 'jumlah']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            // Kembalikan kolom yang dihapus
            $table->unsignedBigInteger('idmenu')->after('idpelanggan');
            $table->integer('jumlah')->after('idmenu');
            // Kembalikan foreign key
            $table->foreign('idmenu')->references('idmenu')->on('menus')->onDelete('cascade');
        });
    }
};
