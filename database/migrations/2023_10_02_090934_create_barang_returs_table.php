<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_returs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_master')->references('id')->on('master_produks')->onDelete('cascade');
            $table->string('nama_supplier');
            $table->string('warna');
            $table->integer('yard');
            $table->integer('stok');
            $table->date('tgl_masuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_returs');
    }
};
