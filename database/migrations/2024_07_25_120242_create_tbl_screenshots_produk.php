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
        Schema::create('tbl_screenshots_produk', function (Blueprint $table) {
            $table->id();
            $table->string('folder');
            $table->unsignedBigInteger('produk_id');
            $table->foreign('produk_id')->references('id')->on('tbl_produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_screenshots_produk');
    }
};
