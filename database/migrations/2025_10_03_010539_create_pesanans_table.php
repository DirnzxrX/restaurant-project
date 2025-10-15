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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('idpesanan');
            $table->unsignedBigInteger('idmenu');
            $table->unsignedBigInteger('idpelanggan');
            $table->integer('jumlah');
            $table->unsignedBigInteger('iduser');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('idmenu')->references('idmenu')->on('menus')->onDelete('cascade');
            $table->foreign('idpelanggan')->references('idpelanggan')->on('pelanggans')->onDelete('cascade');
            $table->foreign('iduser')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
