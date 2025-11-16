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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id('idtransaksi');
            $table->unsignedBigInteger('idpesanan');
            $table->integer('total');
            $table->integer('bayar');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('idpesanan')->references('idpesanan')->on('pesanans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};