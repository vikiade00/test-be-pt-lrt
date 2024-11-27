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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang')->nullable(false);
            $table->enum('kategori_barang',['Elektronik', 'Pakaian', 'Makanan', 'Lainnya']);
            $table->unsignedInteger('jumlah_barang')->default(1)->nullable(false);
            $table->decimal('harga_per_unit', 10, 2)->nullable(false)->default(100.00);
            $table->date('tanggal_masuk')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
