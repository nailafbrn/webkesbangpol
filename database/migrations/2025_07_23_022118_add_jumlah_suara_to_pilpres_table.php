<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('paslons', function (Blueprint $table) {
        // Menambahkan kolom untuk suara presiden
        $table->integer('jumlah_suara_presiden')->unsigned()->default(0)->after('capres_riwayat_pekerjaan');

        // Menambahkan kolom untuk suara wakil presiden
        $table->integer('jumlah_suara_wakil_presiden')->unsigned()->default(0)->after('cawapres_riwayat_pekerjaan');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paslons', function (Blueprint $table) {
            //
        });
    }
};
