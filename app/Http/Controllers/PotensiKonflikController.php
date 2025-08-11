<?php

namespace App\Http\Controllers;

use App\Models\PotensiKonflik;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use App\Imports\PotensiKonflikImport;
use App\Http\Requests\ImportPotensiKonflikRequest;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class PotensiKonflikController extends Controller
{
    public function index()
    {
        $potensiKonfliks = PotensiKonflik::orderBy('tanggal', 'desc')->paginate(10);
        return view('dashboard.potensi_konflik.index', compact('potensiKonfliks'));
    }

    public function create()
    {
        $kecamatanKelurahan = $this->getKecamatanKelurahan();
        return view('dashboard.potensi_konflik.create', compact('kecamatanKelurahan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_potensi' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'lokasi_kecamatan' => 'required|string|max:100',
            'lokasi_kelurahan' => 'nullable|string|max:100',
            'alamat' => 'required|string|min:10',
            'tanggal' => 'required|date',
            'tingkat_potensi' => 'required|in:rendah,sedang,tinggi',
            'deskripsi' => 'required|string|min:10',
            'status' => 'required|in:aktif,selesai',
        ]);

        PotensiKonflik::create([
            'nama_potensi' => $request->nama_potensi,
            'kategori' => $request->kategori,
            'lokasi_kecamatan' => $request->lokasi_kecamatan,
            'lokasi_kelurahan' => $request->lokasi_kelurahan,
            'alamat' => Purifier::clean($request->alamat),
            'tanggal' => $request->tanggal,
            'tingkat_potensi' => $request->tingkat_potensi,
            'deskripsi' => Purifier::clean($request->deskripsi),
            'status' => $request->status,
        ]);

        return redirect()->route('potensi-konflik.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show($id)
    {
        $potensiKonflik = PotensiKonflik::findOrFail($id);
        return view('dashboard.potensi_konflik.show', compact('potensiKonflik'));
    }

    public function edit($id)
    {
        $potensiKonflik = PotensiKonflik::findOrFail($id);
        $kecamatanKelurahan = $this->getKecamatanKelurahan();
        return view('dashboard.potensi_konflik.edit', compact('potensiKonflik', 'kecamatanKelurahan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_potensi' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'lokasi_kecamatan' => 'required|string|max:100',
            'lokasi_kelurahan' => 'nullable|string|max:100',
            'alamat' => 'required|string|min:10',
            'tanggal' => 'required|date',
            'tingkat_potensi' => 'required|in:rendah,sedang,tinggi',
            'deskripsi' => 'required|string|min:10',
            'status' => 'required|in:aktif,selesai',
        ]);

        $potensiKonflik = PotensiKonflik::findOrFail($id);
        $potensiKonflik->update([
            'nama_potensi' => $request->nama_potensi,
            'kategori' => $request->kategori,
            'lokasi_kecamatan' => $request->lokasi_kecamatan,
            'lokasi_kelurahan' => $request->lokasi_kelurahan,
            'alamat' => Purifier::clean($request->alamat),
            'tanggal' => $request->tanggal,
            'tingkat_potensi' => $request->tingkat_potensi,
            'deskripsi' => Purifier::clean($request->deskripsi),
            'status' => $request->status,
        ]);

        return redirect()->route('potensi-konflik.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $potensiKonflik = PotensiKonflik::findOrFail($id);
        $potensiKonflik->delete();

        return redirect()->route('potensi-konflik.index')->with('success', 'Data berhasil dihapus.');
    }

    public function showImportForm()
    {
        return view('dashboard.potensi_konflik.import');
    }

    public function import(ImportPotensiKonflikRequest $request)
    {
        try {
            Excel::import(new PotensiKonflikImport, $request->file('file'));
            return redirect()->route('potensi-konflik.index')
                ->with('success', 'Data berhasil diimpor dari Excel');
        } catch (ValidationException $e) { // Tangkap ValidationException
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $row = $failure->row(); // Baris di Excel
                $attribute = $failure->attribute(); // Kolom yang error
                $errors = implode(', ', $failure->errors()); // Pesan error
                $errorMessages[] = "Baris {$row}, Kolom '{$attribute}': {$errors}";
            }
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan validasi saat impor:<br>' . implode('<br>', $errorMessages));
        } catch (\Exception $e) { // Tangkap exception umum lainnya
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat impor: ' . $e->getMessage());
        }
    }

    private function getKecamatanKelurahan()
    {
        return [
            'Andir' => ['Campaka', 'Ciroyom', 'Dunguscariang', 'Garuda', 'Kebonjeruk', 'Maleber'],
            'Antapani' => ['Antapani Kidul', 'Antapani Kulon', 'Antapani Tengah', 'Antapani Wetan'],
            // Tambah kecamatan lainnya sesuai kebutuhan
        ];
    }
}