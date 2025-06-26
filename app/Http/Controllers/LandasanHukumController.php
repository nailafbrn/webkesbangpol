<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\LandasanHukum;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Http\RedirectResponse;

class LandasanHukumController extends Controller
{

    public function index(): View
    {
        
        $hukum = LandasanHukum::with('bidang')->first()->paginate(5);
        return view('dashboard.landasanhukum.index', compact('hukum'));
    }


    public function create()
    {
        $bidangs = Bidang::all();
        return view('dashboard.landasanhukum.create', compact('bidangs'));
    }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'bidang_id' => 'required|exists:bidangs,id',
            'jenis_peraturan' => 'required|string|max:255',
            'nomor_peraturan' => 'required|string|max:255',
            'tahun_peraturan' => 'required|integer',
            'tentang' => 'required|string',
        ]);

        LandasanHukum::create([
            'bidang_id' => $request->bidang_id,
            'jenis_peraturan' => $request->jenis_peraturan,
            'nomor_peraturan' => $request->nomor_peraturan,
            'tahun_peraturan' => $request->tahun_peraturan,
            'tentang' => Purifier::clean($request->tentang),
        ]);

        return redirect()->route('landasanhukum.index')->with('success', 'Data berhasil disimpan.');

    }

    public function edit($id)
    {
        $landasanHukum = LandasanHukum::findOrFail($id);
        $bidangs = Bidang::all();
        return view('dashboard.landasanhukum.edit', compact('landasanHukum', 'bidangs'));
    }



    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'bidang_id' => 'required|exists:bidangs,id',
            'jenis_peraturan' => 'required|string|max:255',
            'nomor_peraturan' => 'required|string|max:255',
            'tahun_peraturan' => 'required|integer',
            'tentang' => 'required|string',
        ]);

        $hukum = LandasanHukum::findOrFail($id);

        $hukum->update([
            'bidang_id' => $request->bidang_id,
            'jenis_peraturan' => $request->jenis_peraturan,
            'nomor_peraturan' => $request->nomor_peraturan,
            'tahun_peraturan' => $request->tahun_peraturan,
            'tentang' => Purifier::clean($request->tentang),
        ]);

        return redirect()->route('landasanhukum.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    public function destroy($id): RedirectResponse
    {
        $hukum = LandasanHukum::findOrFail($id);
        $hukum->delete();
        return redirect()->route('landasanhukum.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
