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
            // Resep untuk membuat tabel 'programs'
            Schema::create('programs', function (Blueprint $table) {
                $table->id();
                $table->string('nama_program');
                $table->text('deskripsi')->nullable();
                // Anda bisa tambahkan kolom lain di sini jika diperlukan
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('programs');
        }
    };
    