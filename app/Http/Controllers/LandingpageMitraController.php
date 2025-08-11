<?php

namespace App\Http\Controllers;

// Pastikan use statement ini ada di bagian atas file Anda
use App\Models\Mitra;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request; // Mungkin sudah ada

class LandingpageMitraController extends Controller
{
    //
    // ... FUNGSI-FUNGSI LAMA ANDA YANG SUDAH ADA DI SINI ...
    // (misalnya: public function index(), public function isiArtikel(), dll.)
    // Biarkan saja, jangan dihapus.
    //


    // ==========================================================
    // == TAMBAHKAN DUA FUNGSI BARU INI DI BAWAH FUNGSI LAMA ANDA ==
    // ==========================================================

    /**
     * Menampilkan halaman utama /mitra
     */
    public function tampilMitra(): View
    {
        // Menggunakan TRIM untuk memastikan tidak ada masalah whitespace
        $mitraKerjaSama = Mitra::where(DB::raw("TRIM(kategori_mitra)"), '!=', 'PARPOL')->latest()->get();
        $partaiPolitik = Mitra::where(DB::raw("TRIM(kategori_mitra)"), '=', 'PARPOL')->latest()->get();

        return view('landingpage.mitra.index', compact('mitraKerjaSama', 'partaiPolitik'));
    }

    /**
     * Menampilkan halaman detail atau daftar berdasarkan kategori.
     */
    public function detailMitra(string $kategori): View
    {
        // Menerjemahkan slug dari URL ke nilai yang benar di database
        $dbKategori = match (strtolower($kategori)) {
            'partai-politik' => 'PARPOL', // Jika URL-nya 'partai-politik', cari 'PARPOL' di DB
            default => strtoupper($kategori), // Untuk yang lain (kpu, fkdm, dll), langsung ubah ke huruf besar
        };

        // Sekarang kita gunakan nilai yang sudah diterjemahkan
        $mitras = Mitra::where(DB::raw("TRIM(UPPER(kategori_mitra))"), '=', $dbKategori)->get();

        // Jika tidak ada data sama sekali, tampilkan 404
        if ($mitras->isEmpty()) {
            abort(404);
        }

        // Jika HANYA ADA SATU mitra, tampilkan halaman detail
        if ($mitras->count() == 1) {
            $mitra = $mitras->first();
            $mitra->deskripsi = preg_replace('/^\{(.*)\}$/s', '$1', $mitra->deskripsi);
            $mitra->alamat = preg_replace('/^\{(.*)\}$/s', '$1', $mitra->alamat);
            return view('landingpage.mitra.detail', compact('mitra', 'kategori'));
        }

        // Jika ADA BANYAK mitra, tampilkan halaman daftar kategori
        return view('landingpage.mitra.kategori', [
            'mitras' => $mitras,
            'namaKategori' => $kategori
        ]);
    }

} // <-- Kurung kurawal penutup kelas
