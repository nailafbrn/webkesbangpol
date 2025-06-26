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
        // Drop dulu jika sudah ada
        Schema::dropIfExists('ormas');

        Schema::create('ormas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_organisasi');
            $table->string('alamat');
            $table->string('bidang');
            $table->enum('sumber_data', ['verif', 'lsm', 'yayasan']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ormas');
    }
};
