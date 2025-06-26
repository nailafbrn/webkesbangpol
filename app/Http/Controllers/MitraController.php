<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

class MitraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $mitras = Mitra::latest()->paginate(5);
        return view('dashboard.mitras.index', compact('mitras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $mitras = Mitra::all();
        return view('dashboard.mitras.create', compact('mitras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'kategori_mitra' => 'required|in:FORKOPIMDA,KPU,BAWASLU,BNN,PARPOL,FKDM,FKUB,FPK',
            'logo_lembaga' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
            'nama_lembaga' => 'required|string|min:5|max:155',
            'alamat' => 'required|string|min:10',
            'deskripsi' => 'required|string|min:10',
            'foto_ketua' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
            'ketua' => 'required|string|min:5|max:155',
            'kontak' => 'required|string|min:5|max:255',
        ]);

        // Buat nama file unik
        $logoFile = $request->file('logo_lembaga');
        $logoName = time() . '_' . uniqid() . '.' . $logoFile->getClientOriginalExtension();
        $logoPath = public_path('images/mitras/logo/');
        if (!file_exists($logoPath)) {
            mkdir($logoPath, 0775, true); // buat folder jika belum ada
        }
        $logoFile->move($logoPath, $logoName);

        $fotoFile = $request->file('foto_ketua');
        $fotoName = time() . '_' . uniqid() . '.' . $fotoFile->getClientOriginalExtension();
        $fotoPath = public_path('images/mitras/foto_ketua/');
        if (!file_exists($fotoPath)) {
            mkdir($fotoPath, 0775, true);
        }
        $fotoFile->move($fotoPath, $fotoName);

        // Simpan ke database
        Mitra::create([
            'kategori_mitra' => $request->kategori_mitra,
            'logo_lembaga' => $logoName,
            'nama_lembaga' => $request->nama_lembaga,
            'alamat' => Purifier::clean($request->alamat),
            'deskripsi' => Purifier::clean($request->deskripsi),
            'foto_ketua' => $fotoName,
            'ketua' => $request->ketua,
            'kontak'=> $request->kontak,
        ]);

        return redirect()->route('mitras.index')->with(['success' => 'Data Berhasil Disimpan!']);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $mitra = Mitra::findOrFail($id);
        return view('dashboard.mitras.edit', compact('mitra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'kategori_mitra' => 'required|in:FORKOPIMDA,KPU,BAWASLU,BNN,PARPOL,FKDM,FKUB,FPK',
            'logo_lembaga' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'nama_lembaga' => 'required|string|min:5|max:155',
            'alamat' => 'required|string|min:10',
            'deskripsi' => 'required|string|min:10',
            'foto_ketua' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'ketua' => 'required|string|min:5|max:155',
            'kontak' => 'required|string|min:5|max:255',
        ]);

        // Ambil data mitra yang akan diupdate
        $mitra = Mitra::findOrFail($id);

        // Persiapkan data untuk update
        $updateData = [
            'kategori_mitra' => $request->kategori_mitra,
            'nama_lembaga' => $request->nama_lembaga,
            'alamat' => Purifier::clean($request->alamat),
            'deskripsi' => Purifier::clean($request->deskripsi),
            'ketua' => $request->ketua,
            'kontak' => $request->kontak,
        ];

        // Handle logo lembaga jika ada file baru
        if ($request->hasFile('logo_lembaga')) {
            // Hapus logo lama jika ada dan file-nya benar-benar ada
            if ($mitra->logo_lembaga && !empty($mitra->logo_lembaga)) {
                $oldLogoPath = public_path('images/mitras/logo/' . $mitra->logo_lembaga);
                if (file_exists($oldLogoPath)) {
                    unlink($oldLogoPath);
                }
            }

            // Upload logo baru
            $logoFile = $request->file('logo_lembaga');
            $logoName = time() . '_' . uniqid() . '.' . $logoFile->getClientOriginalExtension();
            $logoPath = public_path('images/mitras/logo/');
            
            if (!file_exists($logoPath)) {
                mkdir($logoPath, 0775, true);
            }
            
            $logoFile->move($logoPath, $logoName);
            $updateData['logo_lembaga'] = $logoName;
        }

        // Handle foto ketua jika ada file baru
        if ($request->hasFile('foto_ketua')) {
            // Hapus foto lama jika ada dan file-nya benar-benar ada
            if ($mitra->foto_ketua && !empty($mitra->foto_ketua)) {
                $oldFotoPath = public_path('images/mitras/foto_ketua/' . $mitra->foto_ketua);
                if (file_exists($oldFotoPath)) {
                    unlink($oldFotoPath);
                }
            }

            // Upload foto baru
            $fotoFile = $request->file('foto_ketua');
            $fotoName = time() . '_' . uniqid() . '.' . $fotoFile->getClientOriginalExtension();
            $fotoPath = public_path('images/mitras/foto_ketua/');
            
            if (!file_exists($fotoPath)) {
                mkdir($fotoPath, 0775, true);
            }
            
            $fotoFile->move($fotoPath, $fotoName);
            $updateData['foto_ketua'] = $fotoName;
        }

        // Update data ke database
        $mitra->update($updateData);

        return redirect()->route('mitras.index')->with(['success' => 'Data Berhasil Diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $mitras = Mitra::findOrFail($id);
        $mitras->delete();
        return redirect()->route('mitras.index')->with(['success' => 'Data Berhasil Dihapus!']);
    
        //
    }
}
