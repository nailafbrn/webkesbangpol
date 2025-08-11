<?php

namespace App\Http\Controllers;

use App\Models\Paslon;
use App\Models\Legislatif;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ElectionController extends Controller
{
    /**
     * PERBAIKAN: Mengembalikan fungsi ini untuk menampilkan halaman menu utama pemilu.
     */
    public function index(): View
    {
        return view('landingpage.informasi.index'); 
    }

    /**
     * Menampilkan daftar kandidat berdasarkan kategori.
     */
    public function show($kategori): View
    {
        switch ($kategori) {
            case 'pilpres':
                $judulHalaman = 'Data Pemilu Presiden';
                $paslons = Paslon::where('jenis_pemilu', 'pilpres')->orderBy('no_urut', 'asc')->get();
                $tahunPemilu = $paslons->first()->tahun_pemilu ?? date('Y');
                return view('landingpage.informasi.pilpres.show', compact('paslons', 'judulHalaman', 'tahunPemilu', 'kategori'));

            case 'walikota':
                $judulHalaman = 'Data Pemilu Wali Kota';
                $paslons = Paslon::where('jenis_pemilu', 'walikota')->orderBy('no_urut', 'asc')->get();
                $tahunPemilu = $paslons->first()->tahun_pemilu ?? date('Y');
                return view('landingpage.informasi.walikota.show', compact('paslons', 'judulHalaman', 'tahunPemilu', 'kategori'));

            case 'legislatif':
                $judulHalaman = 'Data Pemilu Legislatif';
                $legislatifs = Legislatif::orderBy('dapil')
                                         ->orderBy('nama_partai')
                                         ->orderBy('no_urut')
                                         ->get();
                
                $groupedLegislatifs = $legislatifs->groupBy('dapil');

                return view('landingpage.informasi.legislatif.show', [
                    'groupedLegislatifs' => $groupedLegislatifs,
                    'judulHalaman' => $judulHalaman,
                    'kategori' => $kategori
                ]);

            default:
                abort(404);
        }
    }

    /**
     * Menampilkan detail dari satu kandidat.
     */
    public function detail($kategori, $id): View
    {
        if ($kategori == 'legislatif') {
            $legislatif = Legislatif::findOrFail($id);
            return view('landingpage.informasi.legislatif.detail', compact('legislatif'));
        }

        $paslon = Paslon::findOrFail($id);
        $viewPath = '';

        if ($paslon->jenis_pemilu == 'pilpres') {
            $viewPath = 'landingpage.informasi.pilpres.detail';
        } elseif ($paslon->jenis_pemilu == 'walikota') {
            $viewPath = 'landingpage.informasi.walikota.detail';
        } else {
            abort(404);
        }

        return view($viewPath, compact('paslon', 'kategori'));
    }
}
