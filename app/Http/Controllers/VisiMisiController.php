<?php

namespace App\Http\Controllers;

use App\Models\VisiMisi;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

class VisiMisiController extends Controller
{
    public function index(): View
    {
        $visimisis = VisiMisi::latest()->paginate(5);
        return view('dashboard.visimisis.index', compact('visimisis'));
    }

    public function create(): View 
    {
        return view('dashboard.visimisis.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'visi' => 'nullable|min:10',
            'misi' => 'nullable|min:10',
            'tupoksi'  => 'nullable|min:10',
            'sejarah'  => 'nullable|min:10',
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images/component'), $imageName);

        VisiMisi::create([
            'visi'    => Purifier::clean($request->visi),
            'misi'    => Purifier::clean($request->misi),
            'tupoksi' => Purifier::clean($request->tupoksi),
            'sejarah' => Purifier::clean($request->sejarah),
            'sejarah_image' => $imageName,
        ]);
        return redirect()->route('visimisis.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id): View
    {
        $visimisis = VisiMisi::findOrFail($id);
        return view('dashboard.visimisis.edit', compact('visimisis'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'visi' => 'nullable|min:10',
            'misi' => 'nullable|min:10',
            'tupoksi'  => 'nullable|min:10',
            'sejarah'  => 'nullable|min:10',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $visimisis = VisiMisi::findOrFail($id);

        if ($request->hasFile('image')) {
            // Upload file baru
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/component'), $imageName);
            
            // Hapus gambar lama jika ada
            $oldImagePath = public_path('images/component/' . $visimisis->sejarah_image);
            if (is_file($oldImagePath)) {
                unlink($oldImagePath);
            }
            $visimisis->update([
            'visi'    => Purifier::clean($request->visi),
            'misi'    => Purifier::clean($request->misi),
            'tupoksi' => Purifier::clean($request->tupoksi),
            'sejarah' => Purifier::clean($request->sejarah),
            'sejarah_image' => $imageName,

            ]);
        } else {
            // Jika tidak ada gambar baru
            $visimisis->update([
                'visi'    => Purifier::clean($request->visi),
                'misi'    => Purifier::clean($request->misi),
                'tupoksi' => Purifier::clean($request->tupoksi),
                'sejarah' => Purifier::clean($request->sejarah),
            ]);
        }

        return redirect()->route('visimisis.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        $visimisis = VisiMisi::findOrFail($id);
        $visimisis->delete();
        return redirect()->route('visimisis.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
