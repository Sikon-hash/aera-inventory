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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->id('id_barang_masuk');
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_supplier');
            $table->unsignedBigInteger('id_user');
            $table->date('tanggal_masuk');
            $table->integer('jumlah_masuk');
            $table->integer('harga_satuan')->default(0);
            $table->text('keterangan')->nullable();
            $table->foreign('id_barang')->references('id_barang')->on('barang');
            $table->foreign('id_supplier')->references('id_supplier')->on('supplier');
            $table->foreign('id_user')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
