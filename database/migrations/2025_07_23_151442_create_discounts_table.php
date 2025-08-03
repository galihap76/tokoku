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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // -- Nama diskon, contoh: "Diskon Ramadhan", "Early Bird"
            $table->enum('type', ['event', 'limit']); // -- 'event' untuk tanggal tertentu, 'limit' untuk kuota pengguna
            $table->decimal('discount_amount', total: 10, places: 0); // -- Nominal potongan, misalnya 50.000
            $table->date('start_date')->nullable(); // -- Tanggal mulai berlaku diskon (khusus tipe 'event')
            $table->date('end_date')->nullable(); // -- Tanggal akhir berlaku diskon (khusus tipe 'event')
            $table->unsignedInteger('usage_limit')->nullable(); // -- Maksimal jumlah penggunaan
            $table->boolean('is_active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
