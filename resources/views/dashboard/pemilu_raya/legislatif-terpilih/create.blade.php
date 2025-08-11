<?php

namespace App\Http\Controllers;

use App\Models\Legislatif;
use App\Models\LegislatifTerpilih;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Imports\LegislatifTerpilihImport;
use Maatwebsite\Excel\Facades\Excel;

class LegislatifTerpilihController extends Controller
{
    public function store(Request $request): RedirectResponse
{
    if ($request->filled('legislatif_id')) {
        // VALIDASI untuk mode pilih caleg yang sudah ada
        $request->validate([
            'legislatif_id' => 'required|exists:legislatifs,id',
            'jabatan' => 'nullable|string|max:255'
        ]);

        LegislatifTerpilih::create([
            'legislatif_id' => $request->legislatif_id,
            'jabatan' => $request->jabatan
        ]);

    } else {
        // VALIDASI untuk mode input caleg baru
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255|unique:legislatifs,nama_lengkap',
            'nama_partai' => 'required|string|max:255',
            'no_urut' => 'required|integer',
            'dapil' => 'required|string|max:255',
            'suara_sah' => 'required|integer|min:0',
            'tempat_lahir' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string',
            'riwayat_pendidikan' => 'nullable|string',
            'riwayat_pekerjaan' => 'nullable|string',
            'jabatan' => 'nullable|string|max:255'
        ]);

        // Buat caleg baru
        $legislatif = Legislatif::create($validatedData);

        // Masukkan ke tabel terpilih
        LegislatifTerpilih::create([
            'legislatif_id' => $legislatif->id,
            'jabatan' => $request->jabatan
        ]);
    }

    return redirect()->route('admin.pemilu.legislatif-terpilih.index')
                     ->with('success', 'Caleg terpilih berhasil ditambahkan.');
}
}