<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProgramController extends Controller
{
    public function index(): View
    {
        $programs = Program::with('bidang')->latest()->paginate(5);
        return view('dashboard.programs.index', compact('programs'));
    }

    public function create(): View 
    {
        $bidangs = Bidang::all();
        return view('dashboard.programs.create', compact('bidangs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'bidang_id' => 'required|exists:bidangs,id',
            'nama_program' => 'required|string|min:5|max:255',
        ]);

        Program::create([
            'bidang_id' => $request->bidang_id,
            'nama_program' => $request->nama_program,
        ]);
        return redirect()->route('programs.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id): View
    {
        $programs = Program::findOrFail($id);
        $bidangs = Bidang::all();
        return view('dashboard.programs.edit', compact('programs', 'bidangs'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'bidang_id' => 'required|exists:bidangs,id',
            'nama_program' => 'required|string|min:5|max:255',
        ]);

        $programs = Program::findOrFail($id);

        $programs->update([
            'bidang_id' => $request->bidang_id,
            'nama_program' => $request->nama_program,
        ]);

        return redirect()->route('programs.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        $programs = Program::findOrFail($id);
        $programs->delete();
        return redirect()->route('programs.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    
    public function getProgramsByBidang(Request $request)
    {
        $programs = Program::where('bidang_id', $request->bidang_id)->get();
        return response()->json($programs);
    }
}
