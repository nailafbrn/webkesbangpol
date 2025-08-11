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
            // Resep untuk membuat tabel 'visi_misis'
            Schema::create('visi_misis', function (Blueprint $table) {
                $table->id();
                $table->text('visi');
                $table->text('misi');
                $table->text('sejarah')->nullable();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('visi_misis');
        }
    };
    