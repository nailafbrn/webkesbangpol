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
        Schema::create('pengurus_ormas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ormas_id')->constrained('ormas')->onDelete('cascade');
            $table->enum('jabatan', ['Ketua', 'Sekretaris', 'Bendahara']);
            $table->string('nama');
            $table->string('no_telepon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengurus_ormas');
    }
};
