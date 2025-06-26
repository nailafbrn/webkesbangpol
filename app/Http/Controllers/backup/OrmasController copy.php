<?php

namespace App\Http\Controllers;

use App\Models\Ormas;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class OrmasController extends Controller
{
    public function index(): View
    {
        $count2 = Ormas::count();
        $ormass = Ormas::latest()->paginate(5);
        return view('dashboard.ormass.index', compact('ormass'));
    }

    public function create(): View
    {
        return view('dashboard.ormass.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'nama_ormas' => 'required|min:5',
            'alamat' => 'required|min:10',
            'ketua' => 'required|min:10',
            'sekertaris' => 'required|min:10',
            'bendahara' => 'required|min:10',
            'tgl_aktanot' => 'required|min:10',
            'no_ahu' => 'required|min:10',
            'bidang' => 'required|min:5',
            'no_telp' => 'required|min:12'
        ]);

        Ormas::create([
            'nama_ormas' => $request->nama_ormas,
            'alamat' => $request->alamat,
            'ketua' => $request->ketua,
            'sekertaris' => $request->sekertaris,
            'bendahara' => $request->bendahara,
            'tgl_aktanot' => $request->tgl_aktanot,
            'no_ahu' => $request->no_ahu,
            'bidang' => $request->bidang,
            'no_telp' => $request->no_telp
        ]);

        return redirect()->route('ormass.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View
    {
        $ormass = Ormas::findOrFail($id);
        return view('dashboard.ormass.show', compact('ormass'));
    }

    public function edit(string $id): View
    {
        $ormass = Ormas::findOrFail($id);
        return view('dashboard.ormass.edit', compact('ormass'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'nama_ormas' => 'required|min:5',
            'alamat' => 'required|min:10',
            'ketua' => 'required|min:10',
            'sekertaris' => 'required|min:10',
            'bendahara' => 'required|min:10',
            'tgl_aktanot' => 'required|min:10',
            'no_ahu' => 'required|min:10',
            'bidang' => 'required|min:5',
            'no_telp' => 'required|min:12'
        ]);

        $ormass = Ormas::findOrFail($id);

        $ormass->update([
            'nama_ormas' => $request->nama_ormas,
            'alamat' => $request->alamat,
            'ketua' => $request->ketua,
            'sekertaris' => $request->sekertaris,
            'bendahara' => $request->bendahara,
            'tgl_aktanot' => $request->tgl_aktanot,
            'no_ahu' => $request->no_ahu,
            'bidang' => $request->bidang,
            'no_telp' => $request->no_telp
        ]);
        return redirect()->route('ormass.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        $ormass = Ormas::findOrFail($id);
        $ormass->delete();
        return redirect()->route('ormass.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
