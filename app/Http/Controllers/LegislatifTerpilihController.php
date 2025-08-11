<?php

namespace App\Http\Controllers;

use App\Models\Legislatif;
use App\Models\LegislatifTerpilih;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Imports\LegislatifTerpilihImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class LegislatifTerpilihController extends Controller
{
    /**
     * Tampilkan daftar caleg terpilih
     */
    public function index(): View
    {
        $terpilihs = LegislatifTerpilih::with('legislatif')
            ->latest()
            ->paginate(10);

        return view('dashboard.pemilu_raya.legislatif-terpilih.index', compact('terpilihs'));
    }

    /**
     * Tampilkan form tambah caleg terpilih
     */
    public function create(): View
    {
        return view('dashboard.pemilu_raya.legislatif-terpilih.create');
    }

    /**
     * Simpan caleg terpilih baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'nama_lengkap'        => 'required|string|max:255|unique:legislatifs,nama_lengkap',
            'nama_partai'         => 'required|string|max:255',
            'no_urut'             => 'required|integer',
            'dapil'               => 'required|string|max:255',
            'suara_sah'           => 'required|integer|min:0',
            'tempat_lahir'        => 'nullable|string|max:255',
            'jenis_kelamin'       => 'nullable|in:L,P',
            'riwayat_pendidikan'  => 'nullable|string',
            'riwayat_pekerjaan'   => 'nullable|string',
            'jabatan'             => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($validatedData) {
            // Simpan data ke tabel legislatifs
            $legislatif = Legislatif::create([
                'no_urut'            => $validatedData['no_urut'],
                'nama_lengkap'       => $validatedData['nama_lengkap'],
                'tempat_lahir'       => $validatedData['tempat_lahir'] ?? null,
                'riwayat_pendidikan' => $validatedData['riwayat_pendidikan'] ?? null,
                'riwayat_pekerjaan'  => $validatedData['riwayat_pekerjaan'] ?? null,
                'jenis_kelamin'      => $validatedData['jenis_kelamin'] ?? null,
                'nama_partai'        => $validatedData['nama_partai'],
                'dapil'              => $validatedData['dapil'],
                'suara_sah'          => $validatedData['suara_sah'],
            ]);

            // Simpan data ke tabel legislatif_terpilihs
            LegislatifTerpilih::create([
                'legislatif_id' => $legislatif->id,
                'jabatan'       => $validatedData['jabatan'] ?? null,
            ]);
        });

        return redirect()->route('admin.pemilu.legislatif-terpilih.index')
            ->with('success', 'Caleg terpilih baru berhasil ditambahkan.');
    }

    /**
     * Form edit caleg terpilih
     */
    public function edit(LegislatifTerpilih $legislatif_terpilih): View
    {
        return view('dashboard.pemilu_raya.legislatif-terpilih.edit', compact('legislatif_terpilih'));
    }

    /**
     * Update data caleg terpilih
     */
    public function update(Request $request, LegislatifTerpilih $legislatif_terpilih): RedirectResponse
    {
        $request->validate([
            'jabatan' => 'nullable|string|max:255'
        ]);

        $legislatif_terpilih->update([
            'jabatan' => $request->jabatan
        ]);

        return redirect()->route('admin.pemilu.legislatif-terpilih.index')
            ->with('success', 'Data caleg terpilih berhasil diperbarui.');
    }

    /**
     * Hapus caleg terpilih
     */
    public function destroy(LegislatifTerpilih $legislatif_terpilih): RedirectResponse
    {
        $legislatif_terpilih->delete();

        return redirect()->route('admin.pemilu.legislatif-terpilih.index')
            ->with('success', 'Data caleg terpilih berhasil dihapus.');
    }

    /**
     * Form import Excel
     */
    public function showImportForm(): View
    {
        return view('dashboard.pemilu_raya.legislatif-terpilih.import');
    }

    /**
     * Proses import dari file Excel
     */
    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new LegislatifTerpilihImport, $request->file('file'));

            return redirect()->route('admin.pemilu.legislatif-terpilih.index')
                ->with('success', 'Data caleg terpilih berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengimpor: ' . $e->getMessage());
        }
    }
}
