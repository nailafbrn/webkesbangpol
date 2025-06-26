<?php

namespace App\Http\Controllers;

use App\Models\Renja;
use Illuminate\Http\Request;
class RenjaController extends Controller
{
    public function index()
    {
        $renjas = Renja::paginate(5);
        return view('dashboard.renja.index', compact('renjas'));
    }

    public function create()
    {
        return view('dashboard.renja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer',
            'file_upload' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'file_upload_wm' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // === Proses file original ===
        $fileOriginal = $request->file('file_upload');
        $originalFileName = time() . '_' . $fileOriginal->getClientOriginalName();
        $originalFilePath = 'document/renja/' . $originalFileName;
        $fileOriginal->move(public_path('document/renja'), $originalFileName);

        // === Proses file watermarked ===
        $fileWm = $request->file('file_upload_wm');
        $wmFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_wm.' . $fileWm->getClientOriginalExtension();
        $wmFilePath = 'document/renja/renja_wm/' . $wmFileName;
        $fileWm->move(public_path('document/renja/renja_wm'), $wmFileName);

        // === Simpan ke DB ===
        Renja::create([
            'title' => $request->title,
            'tahun' => $request->tahun,
            'file_upload' => $originalFilePath,
            'file_upload_wm' => $wmFilePath,
        ]);

        return redirect()->route('renja.index')->with('success', 'Data berhasil disimpan.');
    }


    public function edit($id)
    {
        $renja = Renja::findOrFail($id);
        return view('dashboard.renja.edit', compact('renja'));
    }

    public function update(Request $request, $id)
    {
        $renja = Renja::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'file_upload_wm' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $filePath = $renja->file_upload;
        $wmFilePath = $renja->file_upload_wm;

        // === Update file original ===
        if ($request->hasFile('file_upload')) {
            // Hapus file lama
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }

            // Simpan file baru
            $fileOriginal = $request->file('file_upload');
            $originalFileName = time() . '_' . $fileOriginal->getClientOriginalName();
            $filePath = 'document/renja/' . $originalFileName;
            $fileOriginal->move(public_path('document/renja'), $originalFileName);
        }

        // === Update file watermarked ===
        if ($request->hasFile('file_upload_wm')) {
            // Hapus file lama
            if ($wmFilePath && file_exists(public_path($wmFilePath))) {
                unlink(public_path($wmFilePath));
            }

            // Simpan file baru
            $fileWm = $request->file('file_upload_wm');
            $wmFileName = pathinfo($filePath, PATHINFO_FILENAME) . '_wm.' . $fileWm->getClientOriginalExtension();
            $wmFilePath = 'document/renja/renja_wm/' . $wmFileName;
            $fileWm->move(public_path('document/renja/renja_wm'), $wmFileName);
        }

        // === Update DB ===
        $renja->update([
            'title' => $request->title,
            'tahun' => $request->tahun,
            'file_upload' => $filePath,
            'file_upload_wm' => $wmFilePath,
        ]);

        return redirect()->route('renja.index')->with('success', 'Data berhasil diperbarui.');
    }


    public function destroy(Renja $renja)
    {
        $renja->delete();
        return redirect()->route('renja.index')->with('success', 'Data berhasil dihapus.');
    }


}
