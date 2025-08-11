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
            // Resep untuk membuat tabel 'strukturors'
            Schema::create('strukturors', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('jabatan');
                $table->string('pangkat')->nullable();
                $table->string('foto_profile')->nullable();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('strukturors');
        }
    };
    