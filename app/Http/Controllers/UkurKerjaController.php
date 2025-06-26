<?php

namespace App\Http\Controllers;

use App\Models\UkurKerja;
use Illuminate\Http\Request;
class UkurKerjaController extends Controller
{
    public function index()
    {
        $ukurkerjas = ukurkerja::paginate(5);
        return view('dashboard.ukurkerja.index', compact('ukurkerjas'));
    }

    public function create()
    {
        return view('dashboard.ukurkerja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer',
            'file_upload' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'file_upload_wm' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // === Simpan file original ===
        $fileOriginal = $request->file('file_upload');
        $originalFileName = time() . '_' . $fileOriginal->getClientOriginalName();
        $originalFilePath = 'document/ukurkerja/' . $originalFileName;
        $fileOriginal->move(public_path('document/ukurkerja'), $originalFileName);

        // === Simpan file watermark ===
        $fileWm = $request->file('file_upload_wm');
        $wmFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_wm.' . $fileWm->getClientOriginalExtension();
        $wmFilePath = 'document/ukurkerja/ukurkerja_wm/' . $wmFileName;
        $fileWm->move(public_path('document/ukurkerja/ukurkerja_wm'), $wmFileName);

        ukurkerja::create([
            'title' => $request->title,
            'tahun' => $request->tahun,
            'file_upload' => $originalFilePath,
            'file_upload_wm' => $wmFilePath,
        ]);

        return redirect()->route('ukurkerja.index')->with('success', 'Data berhasil disimpan.');
    }


    public function edit($id)
    {
        $ukurkerja = ukurkerja::findOrFail($id);
        return view('dashboard.ukurkerja.edit', compact('ukurkerja'));
    }

    public function update(Request $request, $id)
    {
        $ukurkerja = ukurkerja::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'file_upload_wm' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $filePath = $ukurkerja->file_upload;
        $wmFilePath = $ukurkerja->file_upload_wm;

        if ($request->hasFile('file_upload')) {
            // Hapus file lama
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }

            // Simpan file baru
            $fileOriginal = $request->file('file_upload');
            $originalFileName = time() . '_' . $fileOriginal->getClientOriginalName();
            $filePath = 'document/ukurkerja/' . $originalFileName;
            $fileOriginal->move(public_path('document/ukurkerja'), $originalFileName);
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
            $wmFilePath = 'document/ukurkerja/ukurkerja_wm/' . $wmFileName;
            $fileWm->move(public_path('document/ukurkerja/ukurkerja_wm'), $wmFileName);
        }

        $ukurkerja->update([
            'title' => $request->title,
            'tahun' => $request->tahun,
            'file_upload' => $filePath,
            'file_upload_wm' => $wmFilePath,
        ]);

        return redirect()->route('ukurkerja.index')->with('success', 'Data berhasil diperbarui.');
    }


    public function destroy(ukurkerja $ukurkerja)
    {
        $ukurkerja->delete();
        return redirect()->route('ukurkerja.index')->with('success', 'Data berhasil dihapus.');
    }
}
