<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IkuController;
use App\Http\Controllers\LandasanHukumController;
use App\Http\Controllers\LandingpageController;
use App\Http\Controllers\LandingpageOrmasController;
use App\Http\Controllers\LandingpagePotensiKonflikController;
use App\Http\Controllers\LandingpageProfileController;
use App\Http\Controllers\LandingpageSakipController;
use App\Http\Controllers\LaporanAkipController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\OrmasController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PotensiKonflikController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RenjaController;
use App\Http\Controllers\RenstraController;
use App\Http\Controllers\StrukturController;
use App\Http\Controllers\UkurKerjaController;
use App\Http\Controllers\VisiMisiController;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;



// AUTH
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware(['auth'])->group(function () {
    // DASHBOARD
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //Beranda
    Route::resource('/posts', PostController::class);
    Route::get('/get-programs-by-bidang', [ProgramController::class, 'getProgramsByBidang'])->name('get-programs-by-bidang');
    Route::resource('/galeris', GaleriController::class);
    Route::resource('/banners', BannerController::class);

    //Profile
    Route::resource('/visimisis', VisiMisiController::class);
    Route::resource('/programs', ProgramController::class);
    Route::resource('/strukturors', StrukturController::class);
    Route::resource('/bidangs', BidangController::class);
    Route::resource('/landasanhukum', LandasanHukumController::class);

    //SAKIP
    Route::resource('/renja', RenjaController::class);
    Route::resource('/renstra', RenstraController::class);
    Route::resource('/iku', IkuController::class);
    Route::resource('/ukurkerja', UkurKerjaController::class);
    Route::resource('/lakip', LaporanAkipController::class);
    
    // Mitra
    Route::resource('/mitras', MitraController::class);

    // Informasi
    Route::resource('/ormass', OrmasController::class);
    Route::post('/ormass/manual', [OrmasController::class, 'inputManualStore'])->name('ormass.inputmanualstore');
    Route::resource('/potensi-konflik', PotensiKonflikController::class);
});



Auth::routes();

// LANDING PAGE
Route::get('/', [LandingpageController::class, 'index'])->name('beranda');
Route::get('/artikel/{slug}', [LandingpageController::class, 'isiArtikel'])->name('isi-artikel');
Route::get('/articles', [LandingpageController::class, 'semuaArtikel'])->name('semua-artikel');
Route::get('/filter-artikel', [LandingpageController::class, 'filterArtikel'])->name('filter-artikel');


// LANDING PAGE PROFILE
Route::get('/visimisi', [LandingpageProfileController::class, 'tampilVisiMisi'])->name('tampilvisimisi');
Route::get('/tugas-fungsi', [LandingpageProfileController::class, 'tampilTugasFungsi'])->name('tampiltugasfungsi');
Route::get('/struktur-organisasi', [LandingpageProfileController::class, 'tampilStruktur'])->name('tampilstruktur');
Route::get('/dasar-hukum', [LandingpageProfileController::class, 'tampilDasarHukum'])->name('tampildasarhukum');
Route::get('/program', [LandingpageProfileController::class, 'tampilProgram'])->name('tampilprogram');
Route::get('/sejarah', [LandingpageProfileController::class, 'tampilSejarah'])->name('tampilsejarah');
Route::get('/profile-badan', [LandingpageProfileController::class, 'tampilMenuProfile'])->name('tampilmenuprofile');

// LANDING PAGE SAKIP
Route::get('/dokumen-regulasi', [LandingpageSakipController::class, 'tampilMenuSakip'])->name('tampilmenusakip');

// RENJA----------------------------------------------------------------------------------------------------------------------------------
Route::get('/rencana-kerja', [LandingpageSakipController::class, 'tampilRenja'])->name('tampilrenja');
// Add these debugging routes to your routes file (web.php)

// Tambahkan route debug-file-renja untuk memeriksa keberadaan file
Route::get('/debug-file-renja/{filename}', function ($filename) {
    // Sanitasi nama file
    $filename = basename($filename);
    
    // Path ke file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'renja'.DIRECTORY_SEPARATOR.$filename);
    
    // Periksa apakah file ada
    $fileExists = file_exists($path);
    
    // Kirim informasi debug
    return response()->json([
        'file_exists' => $fileExists,
        'filename' => $filename,
        'full_path' => $path,
        'directory_exists' => is_dir(dirname($path)),
        'is_readable' => $fileExists ? is_readable($path) : false
    ]);
});

// Method khusus untuk mengatasi blocking oleh AdBlock
Route::get('/file-content-renja/{filename}', function ($filename) {
    // Sanitize the filename
    $filename = basename($filename);
    
    // Path to file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'renja'.DIRECTORY_SEPARATOR.$filename);

    if (!file_exists($path)) {
        return response()->json([
            'error' => 'File not found',
            'path' => $path
        ], 404);
    }

    // Get MIME type
    $mime = mime_content_type($path) ?: 'application/pdf';
    
    // Solusi 2: Enkripsi konten sebagai Base64 
    if (request()->has('encode')) {
        // Baca file sebagai base64
        $content = base64_encode(file_get_contents($path));
        
        // Return sebagai JSON
        return response()->json([
            'filename' => $filename,
            'content' => $content, 
            'mime' => $mime
        ]);
    }
    
    // Solusi 3: Gunakan respons biasa dengan header yang tepat
    return response()->file($path, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="'.basename($filename).'"',
        'X-Content-Type-Options' => 'nosniff',
        'Cache-Control' => 'public, max-age=3600'
    ]);
});



// Tambahkan route baru yang seharusnya tidak diblokir oleh AdBlock
Route::get('/secure-file-renja/{filename}', function ($filename) {
    // Sanitize the filename
    $filename = basename($filename);
    
    // Path to file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'renja'.DIRECTORY_SEPARATOR.$filename);

    if (!file_exists($path)) {
        return response()->json([
            'error' => 'File not found',
            'path' => $path
        ], 404);
    }

    // Get MIME type
    $mime = mime_content_type($path) ?: 'application/pdf';
    
    // Langsung kirim file tanpa redirect
    return response()->file($path, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="'.basename($filename).'"',
        'X-Content-Type-Options' => 'nosniff',
        'Cache-Control' => 'public, max-age=3600'
    ]);
});

// Tambahkan route untuk mengakses konten sebagai Base64
Route::get('/serve-document-renja/{filename}', function ($filename) {
    return redirect("/file-content-renja/{$filename}?encode=true");
});


// RENSTRA --------------------------------------------------------------------------------------------------------------------
Route::get('/rencana-strategis', [LandingpageSakipController::class, 'tampilRenstra'])->name('tampilrenstra');
// Tambahkan route debug-file-renstra untuk memeriksa keberadaan file
Route::get('/debug-file-renstra/{filename}', function ($filename) {
    // Sanitasi nama file
    $filename = basename($filename);
    
    // Path ke file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'renstra'.DIRECTORY_SEPARATOR.$filename);
    
    // Periksa apakah file ada
    $fileExists = file_exists($path);
    
    // Kirim informasi debug
    return response()->json([
        'file_exists' => $fileExists,
        'filename' => $filename,
        'full_path' => $path,
        'directory_exists' => is_dir(dirname($path)),
        'is_readable' => $fileExists ? is_readable($path) : false
    ]);
});

// 1. Method khusus untuk mengatasi blocking oleh AdBlock
Route::get('/file-content-renstra/{filename}', function ($filename) {
    // Sanitize the filename
    $filename = basename($filename);
    
    // Path to file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'renstra'.DIRECTORY_SEPARATOR.$filename);

    if (!file_exists($path)) {
        return response()->json([
            'error' => 'File not found',
            'path' => $path
        ], 404);
    }

    // Get MIME type
    $mime = mime_content_type($path) ?: 'application/pdf';
    
    // Solusi 2: Enkripsi konten sebagai Base64 
    if (request()->has('encode')) {
        // Baca file sebagai base64
        $content = base64_encode(file_get_contents($path));
        
        // Return sebagai JSON
        return response()->json([
            'filename' => $filename,
            'content' => $content, 
            'mime' => $mime
        ]);
    }
    
    // Solusi 3: Gunakan respons biasa dengan header yang tepat
    return response()->file($path, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="'.basename($filename).'"',
        'X-Content-Type-Options' => 'nosniff',
        'Cache-Control' => 'public, max-age=3600'
    ]);
});

// Tambahkan route baru yang seharusnya tidak diblokir oleh AdBlock
Route::get('/secure-file-renstra/{filename}', function ($filename) {
    // Sanitize the filename
    $filename = basename($filename);
    
    // Path to file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'renstra'.DIRECTORY_SEPARATOR.$filename);

    if (!file_exists($path)) {
        return response()->json([
            'error' => 'File not found',
            'path' => $path
        ], 404);
    }

    // Get MIME type
    $mime = mime_content_type($path) ?: 'application/pdf';
    
    // Langsung kirim file tanpa redirect
    return response()->file($path, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="'.basename($filename).'"',
        'X-Content-Type-Options' => 'nosniff',
        'Cache-Control' => 'public, max-age=3600'
    ]);
});

// Tambahkan route untuk mengakses konten sebagai Base64
Route::get('/serve-document-renstra/{filename}', function ($filename) {
    return redirect("/file-content-renstra/{$filename}?encode=true");
});



// INDIKATOR KINERJA----------------------------------------------------------------------------------------------------------------------------------
Route::get('/indikator-kinerja', [LandingpageSakipController::class, 'tampilIku'])->name('tampiliku');
// Add these debugging routes to your routes file (web.php)

// Tambahkan route debug-file-iku untuk memeriksa keberadaan file
Route::get('/debug-file-iku/{filename}', function ($filename) {
    // Sanitasi nama file
    $filename = basename($filename);
    
    // Path ke file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'iku'.DIRECTORY_SEPARATOR.$filename);
    
    // Periksa apakah file ada
    $fileExists = file_exists($path);
    
    // Kirim informasi debug
    return response()->json([
        'file_exists' => $fileExists,
        'filename' => $filename,
        'full_path' => $path,
        'directory_exists' => is_dir(dirname($path)),
        'is_readable' => $fileExists ? is_readable($path) : false
    ]);
});

// Method khusus untuk mengatasi blocking oleh AdBlock
Route::get('/file-content-iku/{filename}', function ($filename) {
    // Sanitize the filename
    $filename = basename($filename);
    
    // Path to file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'iku'.DIRECTORY_SEPARATOR.$filename);

    if (!file_exists($path)) {
        return response()->json([
            'error' => 'File not found',
            'path' => $path
        ], 404);
    }

    // Get MIME type
    $mime = mime_content_type($path) ?: 'application/pdf';
    
    // Solusi 2: Enkripsi konten sebagai Base64 
    if (request()->has('encode')) {
        // Baca file sebagai base64
        $content = base64_encode(file_get_contents($path));
        
        // Return sebagai JSON
        return response()->json([
            'filename' => $filename,
            'content' => $content, 
            'mime' => $mime
        ]);
    }
    
    // Solusi 3: Gunakan respons biasa dengan header yang tepat
    return response()->file($path, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="'.basename($filename).'"',
        'X-Content-Type-Options' => 'nosniff',
        'Cache-Control' => 'public, max-age=3600'
    ]);
});

// Tambahkan route baru yang seharusnya tidak diblokir oleh AdBlock
Route::get('/secure-file-iku/{filename}', function ($filename) {
    // Sanitize the filename
    $filename = basename($filename);
    
    // Path to file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'iku'.DIRECTORY_SEPARATOR.$filename);

    if (!file_exists($path)) {
        return response()->json([
            'error' => 'File not found',
            'path' => $path
        ], 404);
    }

    // Get MIME type
    $mime = mime_content_type($path) ?: 'application/pdf';
    
    // Langsung kirim file tanpa redirect
    return response()->file($path, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="'.basename($filename).'"',
        'X-Content-Type-Options' => 'nosniff',
        'Cache-Control' => 'public, max-age=3600'
    ]);
});

// Tambahkan route untuk mengakses konten sebagai Base64
Route::get('/serve-document-iku/{filename}', function ($filename) {
    return redirect("/file-content-iku/{$filename}?encode=true");
});


// PENGUKURAN KERJA----------------------------------------------------------------------------------------------------------------------------------
Route::get('/pengukuran-kerja', [LandingpageSakipController::class, 'tampilUkurkerja'])->name('tampilukurkerja');
// Add these debugging routes to your routes file (web.php)

// Tambahkan route debug-file-ukurkerja untuk memeriksa keberadaan file
Route::get('/debug-file-ukurkerja/{filename}', function ($filename) {
    // Sanitasi nama file
    $filename = basename($filename);
    
    // Path ke file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'ukurkerja'.DIRECTORY_SEPARATOR.$filename);
    
    // Periksa apakah file ada
    $fileExists = file_exists($path);
    
    // Kirim informasi debug
    return response()->json([
        'file_exists' => $fileExists,
        'filename' => $filename,
        'full_path' => $path,
        'directory_exists' => is_dir(dirname($path)),
        'is_readable' => $fileExists ? is_readable($path) : false
    ]);
});

// Method khusus untuk mengatasi blocking oleh AdBlock
Route::get('/file-content-ukurkerja/{filename}', function ($filename) {
    // Sanitize the filename
    $filename = basename($filename);
    
    // Path to file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'ukurkerja'.DIRECTORY_SEPARATOR.$filename);

    if (!file_exists($path)) {
        return response()->json([
            'error' => 'File not found',
            'path' => $path
        ], 404);
    }

    // Get MIME type
    $mime = mime_content_type($path) ?: 'application/pdf';
    
    // Solusi 2: Enkripsi konten sebagai Base64 
    if (request()->has('encode')) {
        // Baca file sebagai base64
        $content = base64_encode(file_get_contents($path));
        
        // Return sebagai JSON
        return response()->json([
            'filename' => $filename,
            'content' => $content, 
            'mime' => $mime
        ]);
    }
    
    // Solusi 3: Gunakan respons biasa dengan header yang tepat
    return response()->file($path, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="'.basename($filename).'"',
        'X-Content-Type-Options' => 'nosniff',
        'Cache-Control' => 'public, max-age=3600'
    ]);
});

// Tambahkan route baru yang seharusnya tidak diblokir oleh AdBlock
Route::get('/secure-file-ukurkerja/{filename}', function ($filename) {
    // Sanitize the filename
    $filename = basename($filename);
    
    // Path to file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'ukurkerja'.DIRECTORY_SEPARATOR.$filename);

    if (!file_exists($path)) {
        return response()->json([
            'error' => 'File not found',
            'path' => $path
        ], 404);
    }

    // Get MIME type
    $mime = mime_content_type($path) ?: 'application/pdf';
    
    // Langsung kirim file tanpa redirect
    return response()->file($path, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="'.basename($filename).'"',
        'X-Content-Type-Options' => 'nosniff',
        'Cache-Control' => 'public, max-age=3600'
    ]);
});

// Tambahkan route untuk mengakses konten sebagai Base64
Route::get('/serve-document-ukurkerja/{filename}', function ($filename) {
    return redirect("/file-content-ukurkerja/{$filename}?encode=true");
});

// LAPORAN AKIP----------------------------------------------------------------------------------------------------------------------------------
Route::get('/laporan-akip', [LandingpageSakipController::class, 'tampillAkip'])->name('tampillakip');

// Tambahkan route debug-file-lakip untuk memeriksa keberadaan file
Route::get('/debug-file-lakip/{filename}', function ($filename) {
    // Sanitasi nama file
    $filename = basename($filename);
    
    // Path ke file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'lakip'.DIRECTORY_SEPARATOR.$filename);
    
    // Periksa apakah file ada
    $fileExists = file_exists($path);
    
    // Kirim informasi debug
    return response()->json([
        'file_exists' => $fileExists,
        'filename' => $filename,
        'full_path' => $path,
        'directory_exists' => is_dir(dirname($path)),
        'is_readable' => $fileExists ? is_readable($path) : false
    ]);
});

// Method khusus untuk mengatasi blocking oleh AdBlock
Route::get('/file-content-lakip/{filename}', function ($filename) {
    // Sanitize the filename
    $filename = basename($filename);
    
    // Path to file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'lakip'.DIRECTORY_SEPARATOR.$filename);

    if (!file_exists($path)) {
        return response()->json([
            'error' => 'File not found',
            'path' => $path
        ], 404);
    }

    // Get MIME type
    $mime = mime_content_type($path) ?: 'application/pdf';
    
    // Solusi 2: Enkripsi konten sebagai Base64 
    if (request()->has('encode')) {
        // Baca file sebagai base64
        $content = base64_encode(file_get_contents($path));
        
        // Return sebagai JSON
        return response()->json([
            'filename' => $filename,
            'content' => $content, 
            'mime' => $mime
        ]);
    }
    
    // Solusi 3: Gunakan respons biasa dengan header yang tepat
    return response()->file($path, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="'.basename($filename).'"',
        'X-Content-Type-Options' => 'nosniff',
        'Cache-Control' => 'public, max-age=3600'
    ]);
});

// Tambahkan route baru yang seharusnya tidak diblokir oleh AdBlock
Route::get('/secure-file-lakip/{filename}', function ($filename) {
    // Sanitize the filename
    $filename = basename($filename);
    
    // Path to file
    $path = public_path('document'.DIRECTORY_SEPARATOR.'lakip'.DIRECTORY_SEPARATOR.$filename);

    if (!file_exists($path)) {
        return response()->json([
            'error' => 'File not found',
            'path' => $path
        ], 404);
    }

    // Get MIME type
    $mime = mime_content_type($path) ?: 'application/pdf';
    
    // Langsung kirim file tanpa redirect
    return response()->file($path, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="'.basename($filename).'"',
        'X-Content-Type-Options' => 'nosniff',
        'Cache-Control' => 'public, max-age=3600'
    ]);
});

// Tambahkan route untuk mengakses konten sebagai Base64
Route::get('/serve-document-lakip/{filename}', function ($filename) {
    return redirect("/file-content-lakip/{$filename}?encode=true");
});


// LANDING PAGE INFORMASI
// Data Ormas----------------------------------------------------------------------------------------------------------------------------------
Route::get('/data-organisasi-masyarakat', [LandingpageOrmasController::class, 'tampilDataOrmas'])->name('tampil-data-ormas');
Route::get('/jumlah-potensi-konflik', [LandingpagePotensiKonflikController::class, 'tampilPotensiKonflik'])->name('tampil-jumlah-potensi-konflik');


// LANDING PAGE PELAYANAN
Route::get('/maintenance', function () {
    return view('landingpage.pelayanan.maintenance');
})->name('maintenance');