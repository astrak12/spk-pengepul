<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alternatifs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_alternatif')->unique(); 
            $table->string('nama_pengepul');
            $table->text('alamat')->nullable();
            $table->string('no_telp')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alternatifs');
    }
};