<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tr_booking', function (Blueprint $table) {
            $table->id('id_booking');
            $table->unsignedBigInteger('id_cp_koleksi');
            $table->unsignedBigInteger('id_siswa_tetap');
            $table->dateTime('tgl_booking');
            $table->string('status_booking')->default('Aktif');
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->dateTime('expired_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tr_booking');
    }
};