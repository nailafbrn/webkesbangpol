<?php

namespace App\Http\Controllers;

use App\Models\Renstra;
use Illuminate\Http\Request;

class RenstraController extends Controller
{
    public function index()
    {
        $renstras = Renstra::paginate(5);
        return view('dashboard.renstra.index', compact('renstras'));
    }

    public function create()
    {
        return view('dashboard.renstra.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'tahun_mulai' => 'required|digits:4|integer',
            'tahun_selesai' => 'required|digits:4|integer',            
            'file_upload' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'file_upload_wm' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // === Proses file original ===
        $fileOriginal = $request->file('file_upload');
        $originalFileName = time() . '_' . $fileOriginal->getClientOriginalName();
        $originalFilePath = 'document/renstra/' . $originalFileName;
        $fileOriginal->move(public_path('document/renstra'), $originalFileName);

        // === Proses file watermarked ===
        $fileWm = $request->file('file_upload_wm');
        $wmFileName = pathinfo($originalFileName, PATHINFO_FILENAME) . '_wm.' . $fileWm->getClientOriginalExtension();
        $wmFilePath = 'document/renstra/renstra_wm/' . $wmFileName;
        $fileWm->move(public_path('document/renstra/renstra_wm'), $wmFileName);

        Renstra::create([
            'title' => $request->title,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_selesai' => $request->tahun_selesai,
            'file_upload' => $originalFilePath,
            'file_upload_wm' => $wmFilePath,
        ]);

        return redirect()->route('renstra.index')->with('success', 'Data berhasil disimpan.');
    }


    public function edit($id)
    {
        $renstra = Renstra::findOrFail($id);
        return view('dashboard.renstra.edit', compact('renstra'));
    }

    public function update(Request $request, $id)
    {
        $renstra = Renstra::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'tahun_mulai' => 'required|digits:4|integer',
            'tahun_selesai' => 'required|digits:4|integer',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'file_upload_wm' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $filePath = $renstra->file_upload;
        $wmFilePath = $renstra->file_upload_wm;

        // === Update file original ===
        if ($request->hasFile('file_upload')) {
            if ($filePath && file_exists(public_path($filePath))) {
                unlink(public_path($filePath));
            }

            $fileOriginal = $request->file('file_upload');
            $originalFileName = time() . '_' . $fileOriginal->getClientOriginalName();
            $filePath = 'document/renstra/' . $originalFileName;
            $fileOriginal->move(public_path('document/renstra'), $originalFileName);
        }

        // === Update file watermark ===
        if ($request->hasFile('file_upload_wm')) {
            if ($wmFilePath && file_exists(public_path($wmFilePath))) {
                unlink(public_path($wmFilePath));
            }

            $fileWm = $request->file('file_upload_wm');
            $baseFileName = pathinfo($filePath ?? $renstra->file_upload, PATHINFO_FILENAME);
            $wmFileName = $baseFileName . '_wm.' . $fileWm->getClientOriginalExtension();
            $wmFilePath = 'document/renstra/renstra_wm/' . $wmFileName;
            $fileWm->move(public_path('document/renstra/renstra_wm'), $wmFileName);
        }

        $renstra->update([
            'title' => $request->title,
            'tahun_mulai' => $request->tahun_mulai,
            'tahun_selesai' => $request->tahun_selesai,
            'file_upload' => $filePath,
            'file_upload_wm' => $wmFilePath,
        ]);

        return redirect()->route('renstra.index')->with('success', 'Data berhasil diperbarui.');
    }



    public function destroy(Renstra $renstra)
    {
        $renstra->delete();
        return redirect()->route('renstra.index')->with('success', 'Data berhasil dihapus.');
    }
}
