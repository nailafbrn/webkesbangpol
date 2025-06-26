<?php

namespace App\Http\Controllers;

use App\Models\Strukturor;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StrukturController extends Controller
{
    public function index(): View
    {
        $strukturors = Strukturor::first()->paginate(5);
        return view('dashboard.strukturors.index', compact('strukturors'));
    }

    public function create(): View 
    {
        return view('dashboard.strukturors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|min:10',
            'jabatan' => 'required|min:5',
            'nip' => 'required',
            'golongan' => 'required',
            'pangkat' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        $nip = preg_replace('/[^0-9]/', '', $request->nip);

        if(strlen($nip) !== 18){
            return redirect()->back()->withInput()->withErrors(['nip' => 'NIP harus terdiri dari 18 digit angka.']);
        }
        if (Strukturor::where('nip', $nip)->exists()) {
            return redirect()->back()->withInput()->withErrors(['nip' => 'NIP sudah terdaftar.']);
        }

        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $filenameBase = $nip . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $request->golongan) . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $request->pangkat);
        $imageName = $filenameBase . '.' . $extension;
        $image->move(public_path('images/struktur-organisasi'), $imageName);

        Strukturor::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'nip' => $nip,
            'golongan' => $request->golongan,
            'pangkat' => $request->pangkat,
            'foto_profile' => $imageName,
        ]);
        return redirect()->route('strukturors.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id): View
    {
        $strukturors = Strukturor::findOrFail($id);
        return view('dashboard.strukturors.edit', compact('strukturors'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|min:10',
            'jabatan' => 'required|min:5',
            'nip' => 'required',
            'golongan' => 'required',
            'pangkat' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        $nip = preg_replace('/[^0-9]/', '', $request->nip);

        if(strlen($nip) !== 18){
            return redirect()->back()->withInput()->withErrors(['nip' => 'NIP harus terdiri dari 18 digit angka.']);
        }
    
        if (Strukturor::where('nip', $nip)->where('id', '!=', $id)->exists()) {
            return redirect()->back()->withInput()->withErrors(['nip' => 'NIP sudah terdaftar untuk pegawai lain.']);
        }

        $strukturors = Strukturor::findOrFail($id);

        if ($request->hasFile('image')) {
            // Upload file baru
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $filenameBase = $nip . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $request->golongan) . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $request->pangkat);
            $imageName = $filenameBase . '.' . $extension;
            $image->move(public_path('images/struktur-organisasi'), $imageName);
    
            // Hapus gambar lama jika ada
            if (!empty($strukturors->foto_profile)) {
                $oldImagePath = public_path('images/struktur-organisasi/' . $strukturors->foto_profile);

                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $strukturors->update([
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'nip' => $nip,
                'golongan' => $request->golongan,
                'pangkat' => $request->pangkat,
                'foto_profile' => $imageName,
                
            ]);
        } else {
            $strukturors->update([
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'nip' => $request->nip,
                'golongan' => $request->golongan,
                'pangkat' => $request->pangkat,
                
            ]);
        }

        return redirect()->route('strukturors.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        $strukturors = Strukturor::findOrFail($id);
        $strukturors->delete();
        return redirect()->route('strukturors.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function show(): View
    {
        $strukturors = Strukturor::all();
        return view('dashboard.strukturors.show', compact('strukturors'));
    }
}
