<?php

namespace App\Http\Controllers;

use App\Models\Iku;
use Illuminate\Http\Request;
class IkuController extends Controller
{
    public function index()
    {
        $ikus = Iku::paginate(5);
        return view('dashboard.iku.index', compact('ikus'));
    }

    public function create()
    {
        return view('dashboard.iku.create');
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
        $originalFilePath = 'document/iku/' . $originalFileName;
        $fileOriginal->move(public_path('document/iku'), $originalFileName);

        // === Proses file watermark ===
        $fileWm = $request->file('file_upload_wm');
        $wmFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_wm.' . $fileWm->getClientOriginalExtension();
        $wmFilePath = 'document/iku/iku_wm/' . $wmFileName;
        $fileWm->move(public_path('document/iku/iku_wm'), $wmFileName);

        // === Simpan ke DB ===
        Iku::create([
            'title' => $request->title,
            'tahun' => $request->tahun,
            'file_upload' => $originalFilePath,
            'file_upload_wm' => $wmFilePath,
        ]);

        return redirect()->route('iku.index')->with('success', 'Data berhasil disimpan.');
    }


    public function edit($id)
    {
        $iku = Iku::findOrFail($id);
        return view('dashboard.iku.edit', compact('iku'));
    }

    public function update(Request $request, $id)
    {
        $iku = Iku::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'file_upload_wm' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $filePath = $iku->file_upload;
        $wmFilePath = $iku->file_upload_wm;

        // === Update file original ===
        if ($request->hasFile('file_upload')) {
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }

            $fileOriginal = $request->file('file_upload');
            $originalFileName = time() . '_' . $fileOriginal->getClientOriginalName();
            $filePath = 'document/iku/' . $originalFileName;
            $fileOriginal->move(public_path('document/iku'), $originalFileName);
        }

        // === Update file watermarked ===
        if ($request->hasFile('file_upload_wm')) {
            if ($wmFilePath && file_exists(public_path($wmFilePath))) {
                unlink(public_path($wmFilePath));
            }

            $fileWm = $request->file('file_upload_wm');

            // Gunakan nama file asli dari file original yang aktif (baru atau lama)
            $baseFileName = pathinfo($filePath ?? $iku->file_upload, PATHINFO_FILENAME);
            $wmFileName = $baseFileName . '_wm.' . $fileWm->getClientOriginalExtension();
            $wmFilePath = 'document/iku/iku_wm/' . $wmFileName;
            $fileWm->move(public_path('document/iku/iku_wm'), $wmFileName);
        }

        $iku->update([
            'title' => $request->title,
            'tahun' => $request->tahun,
            'file_upload' => $filePath,
            'file_upload_wm' => $wmFilePath,
        ]);

        return redirect()->route('iku.index')->with('success', 'Data berhasil diperbarui.');
    }



    public function destroy(iku $iku)
    {
        $iku->delete();
        return redirect()->route('iku.index')->with('success', 'Data berhasil dihapus.');
    }
}
