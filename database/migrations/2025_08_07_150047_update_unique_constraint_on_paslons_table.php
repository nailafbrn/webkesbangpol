use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('paslons', function (Blueprint $table) {
            // Drop constraint unik pada kolom no_urut (jika ada)
            $table->dropUnique(['no_urut']);

            // Tambahkan composite unique constraint
            $table->unique(['no_urut', 'jenis_pemilu', 'tahun_pemilu'], 'unique_nomor_urut_per_pemilu');
        });
    }

    public function down()
    {
        Schema::table('paslons', function (Blueprint $table) {
            $table->dropUnique('unique_nomor_urut_per_pemilu');

            $table->unique('no_urut');
        });
    }
};
