<?php

namespace App\Http\Controllers;


use App\Models\Ormas;
use App\Models\PengurusOrmas;
use App\Models\DokumenOrmas;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;   
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MultiSheetOrmasImport;
use Mews\Purifier\Facades\Purifier;

class OrmasController extends Controller
{
    public function index(Request $request): View
    {
        $query = Ormas::with(['pengurus', 'dokumen']);
        
        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('nama_organisasi', 'LIKE', '%' . $searchTerm . '%');
        }
        
        $ormass = $query->orderBy('nama_organisasi')
                        ->paginate(10);
                        
        return view('dashboard.ormass.index', compact('ormass'));
    }

    public function create(): View
    {
        return view('dashboard.ormass.create');
    }
    
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');

        try {
            $import = new MultiSheetOrmasImport(false);
            Excel::import($import, $file);
            $data = $import->collectAllData();

            $seenNames = [];
            $sourceMap = [
                'DATA VERIF ORMAS' => 'verif',
                'OrmasLSM'         => 'lsm',
                'Yayasan'          => 'yayasan',
            ];

            foreach (['DATA VERIF ORMAS', 'OrmasLSM', 'Yayasan'] as $sheet) {
                Log::debug("Mulai memproses sheet: {$sheet}");
                $enumValue = $sourceMap[$sheet] ?? null;

                foreach (($data[$sheet] ?? []) as $index => $row) {
                    $namaKey = trim(strtolower($row['nama_organisasi'] ?? ''));
                    if (empty($namaKey)) {
                        Log::debug("[{$sheet}][{$index}] Skip: Nama kosong");
                        continue;
                    }

                    // 1) SKIP jika Ormas sudah ada
                    if (Ormas::whereRaw('LOWER(nama_organisasi) = ?', [$namaKey])->exists()) {
                        Log::debug("[{$sheet}][{$index}] Skip Ormas: '{$row['nama_organisasi']}' sudah ada");
                        continue;
                    }

                    // 1a) SKIP jika alamat atau bidang kosong
                    if (empty($row['alamat']) || empty($row['bidang'])) {
                        Log::debug("[{$sheet}][{$index}] Skip Ormas: Alamat atau bidang kosong");
                        continue;
                    }

                    $ormas = Ormas::create([
                        'nama_organisasi' => $row['nama_organisasi'],
                        'alamat'          => $row['alamat'],     // wajib ada
                        'bidang'          => $row['bidang'],     // wajib ada
                        'sumber_data'     => $enumValue,
                    ]);
                    Log::debug("[{$sheet}][{$index}] Ormas dibuat: ID {$ormas->id}");


                    // Simpan dokumen jika ada, matching berdasarkan ormas_id
                    if (!empty($row['akta']) || !empty($row['ahu_skt']) || !empty($row['npwp'])) {
                        DokumenOrmas::create([
                            'ormas_id'      => $ormas->id,
                            'akta_notaris'  => $row['akta']  ?? null,
                            'ahu_skt'       => $row['ahu_skt'] ?? null,
                            'npwp'          => $row['npwp']   ?? null,
                        ]);
                    }

                    // Simpan pengurus jika ada, matching berdasarkan kombinasi unik
                    if (!empty($row['pengurus'])) {
                        foreach ($row['pengurus'] as $pengurus) {
                            PengurusOrmas::create([
                                'ormas_id'    => $ormas->id,
                                'jabatan'     => $pengurus['jabatan'],
                                'nama'        => $pengurus['nama'],
                                'no_telepon'  => $pengurus['telepon'] ?? null,
                            ]);
                        }
                    }
                }

                Log::debug("Selesai memproses sheet: {$sheet}");
            }

            return redirect()->route('ormass.index')->with('success', 'File berhasil diimport');
        } catch (\Exception $e) {
            Log::error("Gagal import file Excel: " . $e->getMessage());
            return redirect()->route('ormass.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function inputManualStore(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $validated = $request->validate([
            'nama_organisasi'       => 'required|string|max:255',
            'bidang'                => 'required|string|max:255',
            'alamat'                => 'required|string',
            'sumber_data'           => 'required|string|max:255',
            'dokumen.akta_notaris'  => 'nullable|string|max:255',
            'dokumen.ahu_skt'       => 'nullable|string|max:255',
            'dokumen.npwp'          => 'nullable|string|max:255',
            'pengurus'              => 'nullable|array|min:1',
            'pengurus.*.nama'       => 'nullable|string|max:255',
            'pengurus.*.jabatan'    => 'nullable|string|in:Ketua,Sekretaris,Bendahara',
            'pengurus.*.no_telepon' => ['nullable','string','max:20','regex:/^[0-9+\-\s]+$/'],
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // 2. Simpan data ormas
                $ormas = Ormas::create([
                    'nama_organisasi' => $validated['nama_organisasi'],
                    'bidang'          => $validated['bidang'],
                    'alamat'          => Purifier::clean($validated['alamat']),
                    'sumber_data'     => $validated['sumber_data'],
                ]);

                // 3. Simpan dokumen ormas
                DokumenOrmas::create([
                    'ormas_id'      => $ormas->id,
                    'akta_notaris'  => $validated['dokumen']['akta_notaris'] ?? null,
                    'ahu_skt'       => $validated['dokumen']['ahu_skt'] ?? null,
                    'npwp'          => $validated['dokumen']['npwp'] ?? null,
                ]);

                // 4. Simpan setiap pengurus
                foreach ($validated['pengurus'] as $p) {
                    PengurusOrmas::create([
                        'ormas_id'   => $ormas->id,
                        'jabatan'    => $p['jabatan'] ?? null,
                        'nama'       => $p['nama'] ?? null,
                        'no_telepon' => $p['no_telepon'] ?? null,
                    ]);
                }
            });

            return redirect()
                ->route('ormass.index')
                ->with('success', 'Data organisasi berhasil disimpan');
        } catch (\Throwable $e) {
            Log::error('Gagal input manual ormas: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()
                ->route('ormass.index')
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }


    public function edit(int $id): View|RedirectResponse
    {
        try {
            // Fetch the ormas with related data
            $ormas = Ormas::with(['pengurus', 'dokumenedit'])->findOrFail($id);
            
            return view('dashboard.ormass.edit', compact('ormas'));
        } catch (\Exception $e) {
            Log::error('Error saat mengambil data ormas untuk edit: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->route('ormass.index')
                ->with('error', 'Data organisasi tidak ditemukan');
        }
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        // 1. Validasi input
        $validated = $request->validate([
            'nama_organisasi'       => 'required|string|max:255',
            'bidang'                => 'required|string|max:255',
            'alamat'                => 'required|string',
            'sumber_data'           => 'required|string|max:255',
            'dokumen.akta_notaris'  => 'nullable|string|max:255',
            'dokumen.ahu_skt'       => 'nullable|string|max:255',
            'dokumen.npwp'          => 'nullable|string|max:255',
            'pengurus'              => 'nullable|array|min:1',
            'pengurus.*.nama'       => 'nullable|string|max:255',
            'pengurus.*.jabatan'    => 'nullable|string|in:Ketua,Sekretaris,Bendahara',
            'pengurus.*.no_telepon' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'pengurus.*.id'         => 'nullable|exists:pengurus_ormas,id',
        ]);

        try {
            // Cek apakah data ormas ada
            $ormas = Ormas::findOrFail($id);

            DB::transaction(function () use ($validated, $ormas) {
                // 2. Update data ormas
                $ormas->update([
                    'nama_organisasi' => $validated['nama_organisasi'],
                    'bidang'          => $validated['bidang'],
                    'alamat'          => Purifier::clean($validated['alamat']),
                    'sumber_data'     => $validated['sumber_data'],
                ]);

                // 3. Update dokumen ormas (menangani nilai null/kosong)
                if (isset($validated['dokumen']) && is_array($validated['dokumen'])) {
                    $dokumenData = [
                        'akta_notaris' => $validated['dokumen']['akta_notaris'] ?? null,
                        'ahu_skt'      => $validated['dokumen']['ahu_skt'] ?? null,
                        'npwp'         => $validated['dokumen']['npwp'] ?? null,
                    ];
                    
                    // Filter nilai yang tidak null
                    $dokumenData = array_filter($dokumenData, function($value) {
                        return $value !== null && $value !== '';
                    });
                    
                    if (!empty($dokumenData)) {
                        DokumenOrmas::updateOrCreate(
                            ['ormas_id' => $ormas->id],
                            $dokumenData
                        );
                    }
                }

                // 4. Update setiap pengurus (menangani nilai null/kosong)
                if (isset($validated['pengurus']) && is_array($validated['pengurus'])) {
                    foreach ($validated['pengurus'] as $p) {
                        // Siapkan data untuk pengurus
                        $pengurusData = [
                            'nama'       => $p['nama'] ?? null,
                            'no_telepon' => $p['no_telepon'] ?? null,
                        ];
                        
                        // Filter nilai yang tidak null
                        $pengurusData = array_filter($pengurusData, function($value) {
                            return $value !== null && $value !== '';
                        });
                        
                        // Hanya update/create jika ada data valid
                        if (!empty($pengurusData)) {
                            if (!empty($p['id'])) {
                                // Update pengurus yang sudah ada
                                PengurusOrmas::where('id', $p['id'])
                                    ->where('ormas_id', $ormas->id)
                                    ->update($pengurusData);
                            } else if (!empty($p['jabatan'])) {
                                // Tambahkan jabatan ke data pengurus untuk pembuatan baru
                                $pengurusData['jabatan'] = $p['jabatan'];
                                $pengurusData['ormas_id'] = $ormas->id;
                                
                                // Buat pengurus baru
                                PengurusOrmas::create($pengurusData);
                            }
                        }
                    }
                }
            });

            return redirect()
                ->route('ormass.index')
                ->with('success', 'Data organisasi berhasil diperbarui');
        } catch (\Throwable $e) {
            Log::error('Gagal update ormas: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->route('ormass.edit', $id)
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(int $id): RedirectResponse
    {
        try {
            // Find the Ormas
            $ormas = Ormas::findOrFail($id);
            
            // Use transaction to ensure data consistency
            DB::transaction(function () use ($ormas) {
                // Delete related data first to maintain referential integrity
                // This assumes cascading deletes aren't set up in the database
                PengurusOrmas::where('ormas_id', $ormas->id)->delete();
                DokumenOrmas::where('ormas_id', $ormas->id)->delete();
                
                // Finally delete the Ormas itself
                $ormas->delete();
            });
            
            return redirect()
                ->route('ormass.index')
                ->with('success', 'Data organisasi berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus ormas: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->route('ormass.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
