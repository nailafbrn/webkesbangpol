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
            Schema::table('posts', function (Blueprint $table) {
                // Resep untuk menambahkan kolom 'bidang_id'
                $table->foreignId('bidang_id')->nullable()->constrained('bidangs')->onDelete('set null');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropForeign(['bidang_id']);
                $table->dropColumn('bidang_id');
            });
        }
    };
    