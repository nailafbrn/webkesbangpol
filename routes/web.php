<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import Controllers
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;

// Landing Page Controllers
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\LandingpageOrmasController;
use App\Http\Controllers\LandingpagePotensiKonflikController;
use App\Http\Controllers\LandingpageProfileController;
use App\Http\Controllers\LandingpageSakipController;
use App\Http\Controllers\LandingpageMitraController;

// Admin/Dashboard Controllers
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\IkuController;
use App\Http\Controllers\LaporanAkipController;
use App\Http\Controllers\LandasanHukumController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\OrmasController;
use App\Http\Controllers\PemiluRayaController;
use App\Http\Controllers\PilpresController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PotensiKonflikController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RenjaController;
use App\Http\Controllers\RenstraController;
use App\Http\Controllers\StrukturController;
use App\Http\Controllers\UkurKerjaController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\WalikotaController;

// Newly added controller for Legislatif
use App\Http\Controllers\LegislatifController;
// use App\Http\Controllers\LegislatifTerpilihController;
// Placeholder for Legislatif Terpilih Controller
// use App\Http\Controllers\LegislatifTerpilihController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dalam sebuah grup yang
| berisi grup middleware "web".
|
*/

//========================================================================
// AUTHENTICATION ROUTES
//========================================================================
Auth::routes();


//========================================================================
// LANDING PAGE ROUTES (PUBLIC)
//========================================================================
Route::get('/', [LandingpageController::class, 'index'])->name('beranda');
Route::get('/artikel/{slug}', [LandingpageController::class, 'isiArtikel'])->name('isi-artikel');
Route::get('/articles', [LandingpageController::class, 'semuaArtikel'])->name('semua-artikel');
Route::get('/filter-artikel', [LandingpageController::class, 'filterArtikel'])->name('filter-artikel');

// LANDING PAGE - PROFILE
Route::prefix('profile')->group(function () {
    Route::get('/', [LandingpageProfileController::class, 'tampilMenuProfile'])->name('tampilmenuprofile');
    Route::get('/visimisi', [LandingpageProfileController::class, 'tampilVisiMisi'])->name('tampilvisimisi');
    Route::get('/tugas-fungsi', [LandingpageProfileController::class, 'tampilTugasFungsi'])->name('tampiltugasfungsi');
    Route::get('/struktur-organisasi', [LandingpageProfileController::class, 'tampilStruktur'])->name('tampilstruktur');
    Route::get('/dasar-hukum', [LandingpageProfileController::class, 'tampilDasarHukum'])->name('tampildasarhukum');
    Route::get('/program', [LandingpageProfileController::class, 'tampilProgram'])->name('tampilprogram');
    Route::get('/sejarah', [LandingpageProfileController::class, 'tampilSejarah'])->name('tampilsejarah');
});

// LANDING PAGE - SAKIP (Sistem Akuntabilitas Kinerja Instansi Pemerintah)
Route::prefix('sakip')->group(function () {
    Route::get('/', [LandingpageSakipController::class, 'tampilMenuSakip'])->name('tampilmenusakip');
    Route::get('/rencana-kerja', [LandingpageSakipController::class, 'tampilRenja'])->name('tampilrenja');
    Route::get('/rencana-strategis', [LandingpageSakipController::class, 'tampilRenstra'])->name('tampilrenstra');
    Route::get('/indikator-kinerja', [LandingpageSakipController::class, 'tampilIku'])->name('tampiliku');
    Route::get('/pengukuran-kerja', [LandingpageSakipController::class, 'tampilUkurkerja'])->name('tampilukurkerja');
    Route::get('/laporan-akip', [LandingpageSakipController::class, 'tampillAkip'])->name('tampillakip');
});

// LANDING PAGE - INFORMASI
Route::get('/data-organisasi-masyarakat', [LandingpageOrmasController::class, 'tampilDataOrmas'])->name('tampil-data-ormas');
Route::get('/jumlah-potensi-konflik', [LandingpagePotensiKonflikController::class, 'tampilPotensiKonflik'])->name('tampil-jumlah-potensi-konflik');

// LANDING PAGE - MITRA
Route::get('/mitra', [LandingpageMitraController::class, 'tampilMitra'])->name('tampilmitra');
Route::get('/mitra/{kategori}', [LandingpageMitraController::class, 'detailMitra'])->name('mitra.detail');
Route::get('/mitra/detail/{mitra}', [LandingpageController::class, 'showMitraDetail'])->name('mitra.show.detail');

// LANDING PAGE - PEMILU
Route::get('/pemilu', [ElectionController::class, 'index'])->name('pemilu.index');
Route::get('/pemilu/{kategori}', [ElectionController::class, 'show'])->name('pemilu.show');
Route::get('/pemilu/{kategori}/{id}', [ElectionController::class, 'detail'])->name('pemilu.detail');
// Route::get('/pemilu/legislatif/terpilih', [ElectionController::class, 'showLegislatifTerpilih'])->name('pemilu.legislatif.terpilih');
Route::get('/pemilu/{kategori}', [ElectionController::class, 'show'])->name('pemilu.show');
Route::get('/pemilu/{kategori}/{id}', [ElectionController::class, 'detail'])->name('pemilu.detail');


//========================================================================
// ADMIN/DASHBOARD ROUTES (PROTECTED BY AUTH MIDDLEWARE)
//========================================================================
Route::middleware(['auth'])->group(function () {
    // DASHBOARD
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // BERANDA MANAGEMENT
    Route::resource('/posts', PostController::class);
    Route::resource('/galeris', GaleriController::class);
    Route::resource('/banners', BannerController::class);

    // PROFILE MANAGEMENT
    Route::resource('/visimisis', VisiMisiController::class);
    Route::resource('/programs', ProgramController::class);
    Route::get('/get-programs-by-bidang', [ProgramController::class, 'getProgramsByBidang'])->name('get-programs-by-bidang');
    Route::resource('/strukturors', StrukturController::class);
    Route::resource('/bidangs', BidangController::class);
    Route::resource('/landasanhukum', LandasanHukumController::class);

    // SAKIP MANAGEMENT
    Route::resource('/renja', RenjaController::class);
    Route::resource('/renstra', RenstraController::class);
    Route::resource('/iku', IkuController::class);
    Route::resource('/ukurkerja', UkurKerjaController::class);
    Route::resource('/lakip', LaporanAkipController::class);
    
    // MITRA MANAGEMENT
    Route::resource('/mitras', MitraController::class);

    // INFORMASI MANAGEMENT
    // -- Ormas
    Route::resource('/ormass', OrmasController::class);
    Route::post('/ormass/manual', [OrmasController::class, 'inputManualStore'])->name('ormass.inputmanualstore');
    
    // -- Potensi Konflik Management
    Route::get('/potensi-konflik/import', [PotensiKonflikController::class, 'showImportForm'])->name('potensi-konflik.import.form');
    Route::post('/potensi-konflik/import', [PotensiKonflikController::class, 'import'])->name('potensi-konflik.import');
    Route::resource('/potensi-konflik', PotensiKonflikController::class);

    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    
    // Dashboard Admin
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/pemilu-raya', [PemiluRayaController::class, 'index'])->name('pemilu-raya.dashboard');

    // Manajemen Pemilu
    Route::prefix('pemilu')->name('pemilu.')->group(function () {
        
        Route::resource('pilpres', PilpresController::class);
        Route::resource('walikota', WalikotaController::class);
        
        // Manajemen Legislatif
        Route::delete('legislatif/destroy-all', [LegislatifController::class, 'destroyAll'])->name('legislatif.destroy.all');
        Route::get('legislatif/import', [LegislatifController::class, 'showImportForm'])->name('legislatif.import.form');
        Route::post('legislatif/import', [LegislatifController::class, 'import'])->name('legislatif.import');
        Route::resource('legislatif', LegislatifController::class);
        
        // // Legislatif Terpilih Routes
        // Route::get('/pemilu/legislatif/terpilih', [LegislatifController::class, 'terpilih'])
        // ->name('pemilu.legislatif.terpilih');

        // // Resource untuk legislatif terpilih (jika butuh CRUD penuh)
        // Route::resource('/legislatif-terpilih', LegislatifTerpilihController::class);

        // Resource untuk legislatif biasa
        Route::resource('/legislatif', LegislatifController::class);
    });
    });
});


//========================================================================
// FILE SERVING & DEBUGGING ROUTES
//========================================================================
function serveDocument($directory, $filename) {
    // Sanitize filename to prevent directory traversal attack
    $filename = basename($filename);
    $path = public_path('document' . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $filename);

    if (!file_exists($path)) {
        return response()->json(['error' => 'File not found', 'path' => $path], 404);
    }

    $mime = mime_content_type($path) ?: 'application/octet-stream';

    if (request()->has('encode')) {
        $content = base64_encode(file_get_contents($path));
        return response()->json([
            'filename' => $filename,
            'content' => $content,
            'mime' => $mime
        ]);
    }

    return response()->file($path, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="' . basename($filename) . '"',
    ]);
}

Route::get('/file-content-renja/{filename}', fn($filename) => serveDocument('renja', $filename));
Route::get('/file-content-renstra/{filename}', fn($filename) => serveDocument('renstra', $filename));
Route::get('/file-content-iku/{filename}', fn($filename) => serveDocument('iku', $filename));
Route::get('/file-content-ukurkerja/{filename}', fn($filename) => serveDocument('ukurkerja', $filename));
Route::get('/file-content-lakip/{filename}', fn($filename) => serveDocument('lakip', $filename));
