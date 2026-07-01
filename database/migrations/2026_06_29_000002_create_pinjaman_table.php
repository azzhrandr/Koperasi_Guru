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
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('nominal_pinjaman', 15, 2);
            $table->decimal('bunga_persen', 5, 2)->default(0.00);
            $table->integer('lama_angsuran_bulan');
            $table->integer('sisa_angsuran_bulan');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'berjalan', 'lunas'])->default('menunggu');
            $table->text('alasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
