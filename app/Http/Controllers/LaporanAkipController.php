<?php

namespace App\Http\Controllers;

use App\Models\LaporanAkip;
use Illuminate\Http\Request;

class LaporanAkipController extends Controller
{
    public function index()
    {
        $lakips = LaporanAkip::paginate(5);
        return view('dashboard.lakip.index', compact('lakips'));
    }

    public function create()
    {
        return view('dashboard.lakip.create');
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
        $originalFilePath = 'document/lakip/' . $originalFileName;
        $fileOriginal->move(public_path('document/lakip'), $originalFileName);

        // === Proses file watermarked ===
        $fileWm = $request->file('file_upload_wm');
        $wmFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_wm.' . $fileWm->getClientOriginalExtension();
        $wmFilePath = 'document/lakip/lakip_wm/' . $wmFileName;
        $fileWm->move(public_path('document/lakip/lakip_wm'), $wmFileName);

        // === Simpan ke DB ===
        LaporanAkip::create([
            'title' => $request->title,
            'tahun' => $request->tahun,
            'file_upload' => $originalFilePath,
            'file_upload_wm' => $wmFilePath,
        ]);

        return redirect()->route('lakip.index')->with('success', 'Data berhasil disimpan.');
    }


    public function edit($id)
    {
        $lakip = LaporanAkip::findOrFail($id);
        return view('dashboard.lakip.edit', compact('lakip'));
    }

    public function update(Request $request, $id)
    {
        $lakip = LaporanAkip::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'file_upload_wm' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $filePath = $lakip->file_upload;
        $wmFilePath = $lakip->file_upload_wm;

        // === Update file original ===
        if ($request->hasFile('file_upload')) {
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }

            $fileOriginal = $request->file('file_upload');
            $originalFileName = time() . '_' . $fileOriginal->getClientOriginalName();
            $filePath = 'document/lakip/' . $originalFileName;
            $fileOriginal->move(public_path('document/lakip'), $originalFileName);
        }

        // === Update file watermark ===
        if ($request->hasFile('file_upload_wm')) {
            if ($wmFilePath && file_exists(public_path($wmFilePath))) {
                unlink(public_path($wmFilePath));
            }

            $fileWm = $request->file('file_upload_wm');

            // Gunakan nama file original (baru jika ada, lama jika tidak)
            $baseFileName = pathinfo($filePath ?? $lakip->file_upload, PATHINFO_FILENAME);
            $wmFileName = $baseFileName . '_wm.' . $fileWm->getClientOriginalExtension();
            $wmFilePath = 'document/lakip/lakip_wm/' . $wmFileName;
            $fileWm->move(public_path('document/lakip/lakip_wm'), $wmFileName);
        }

        $lakip->update([
            'title' => $request->title,
            'tahun' => $request->tahun,
            'file_upload' => $filePath,
            'file_upload_wm' => $wmFilePath,
        ]);

        return redirect()->route('lakip.index')->with('success', 'Data berhasil diperbarui.');
    }



    public function destroy(LaporanAkip $lakip)
    {
        $lakip->delete();
        return redirect()->route('lakip.index')->with('success', 'Data berhasil dihapus.');
    }
}
