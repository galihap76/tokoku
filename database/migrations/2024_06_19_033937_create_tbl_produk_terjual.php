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
        Schema::create('tbl_produk_terjual', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah_terjual');
            $table->unsignedBigInteger('produk_id');
            $table->foreign('produk_id')->references('id')->on('tbl_produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_produk_terjual');
    }
};
