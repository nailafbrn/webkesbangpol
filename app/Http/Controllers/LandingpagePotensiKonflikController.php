<?php

namespace App\Http\Controllers;

use App\Models\PotensiKonflik;
use Illuminate\Http\Request;

class LandingpagePotensiKonflikController extends Controller
{
    public function tampilPotensiKonflik(Request $request)
    {
        // ✅ DATA UNTUK MAP & CHART: TETAP SEMUA DATA (TIDAK TERFILTER)
        $potensiKonfliks = PotensiKonflik::all();
        
        // ✅ DATA UNTUK TABEL: DIFILTER BERDASARKAN year_filter (JIKA ADA)
        $tableQuery = PotensiKonflik::query();
        
        // Filter berdasarkan tahun HANYA untuk tabel
        if ($request->has('year_filter') && !empty($request->year_filter)) {
            $year = $request->year_filter;
            $tableQuery->whereYear('tanggal', $year);
        }
        
        $tableQuery->orderByRaw('YEAR(tanggal) DESC, MONTH(tanggal) ASC, DAY(tanggal) ASC');
        $potensiKonfliks1 = $tableQuery->paginate(10);
        
        // Pertahankan parameter filter di pagination links
        $potensiKonfliks1->appends($request->query());
        
        // ✅ STATISTIK: TETAP MENGGUNAKAN SEMUA DATA (UNTUK MAP & CHART)
        $statistikKategori = PotensiKonflik::select('kategori')
            ->selectRaw('count(*) as total')
            ->groupBy('kategori')
            ->pluck('total', 'kategori');
            
        $statistikKecamatan = PotensiKonflik::select('lokasi_kecamatan')
            ->selectRaw('count(*) as total')
            ->groupBy('lokasi_kecamatan')
            ->pluck('total', 'lokasi_kecamatan');
            
        $statistikTingkat = PotensiKonflik::select('tingkat_potensi')
            ->selectRaw('count(*) as total')
            ->groupBy('tingkat_potensi')
            ->pluck('total', 'tingkat_potensi');
            
        $statistikKelurahan = PotensiKonflik::select('lokasi_kelurahan', 'lokasi_kecamatan')
            ->selectRaw('count(*) as total')
            ->groupBy('lokasi_kelurahan', 'lokasi_kecamatan')
            ->get()
            ->keyBy('lokasi_kelurahan');
            
        return view('landingpage.informasi.potensi-konflik', compact(
            'potensiKonfliks',      // ← Untuk Map & Chart (semua data)
            'potensiKonfliks1',     // ← Untuk Tabel (data terfilter + pagination)
            'statistikKategori',    // ← Untuk Chart (semua data)
            'statistikKecamatan',   // ← Untuk Chart (semua data)
            'statistikTingkat',     // ← Untuk Chart (semua data)
            'statistikKelurahan'    // ← Untuk Map (semua data)
        ));
    }
}
