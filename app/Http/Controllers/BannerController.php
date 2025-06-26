<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BannerController extends Controller
{
    public function index(): View
    {
        $banners = Banner::latest()->paginate(5);
        return view('dashboard.banners.index', compact('banners'));
    }

    public function create(): View 
    {
        return view('dashboard.banners.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'judul' => 'required|string|min:5|max:100',
            'caption' => 'required|string|min:5|max:100',
            'image'   => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',

        ]);

        $image = $request->file('image');
        $slugJudul = Str::slug($request->input('judul')); // misal: "upacara-hut-ri"
        $tanggal   = Carbon::now()->format('Ymd');        // misal: "20250523"
        $ext       = $image->getClientOriginalExtension();// misal: "jpg"

        $baseName  = "{$slugJudul}_{$tanggal}";           // misal: "upacara-hut-ri_20250523"
        $imageName = "{$baseName}.{$ext}";                // nama awal

        $path = public_path('images/banner');
        $counter = 1;

        // Cek jika file sudah ada, tambahkan angka
        while (file_exists("{$path}/{$imageName}")) {
            $imageName = "{$baseName}-{$counter}.{$ext}";
            $counter++;
        }

        // Pindahkan file ke direktori
        $image->move($path, $imageName);
        
        Banner::create([
            'judul' => $request->judul,
            'caption' => $request->caption,
            'gambar_upload' => $imageName,
        ]);
        return redirect()->route('banners.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(string $id): View
    {
        $banners = Banner::findOrFail($id);
        return view('dashboard.banners.edit', compact('banners'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'judul' => 'required|string|min:5|max:100',
            'caption' => 'required|string|min:5|max:100',
            'image'   => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        $banners = Banner::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $slugJudul = Str::slug($request->judul);
            $tanggal = Carbon::now()->format('Ymd');
            $ext = $image->getClientOriginalExtension();

            $baseName = "{$slugJudul}_{$tanggal}";
            $imageName = "{$baseName}.{$ext}";
            $path = public_path('images/banner');
            $counter = 1;

            // Cek jika nama file sudah ada
            while (file_exists("{$path}/{$imageName}")) {
                $imageName = "{$baseName}-{$counter}.{$ext}";
                $counter++;
            }

            // Hapus gambar lama jika ada
            $oldImagePath = public_path('images/banner/' . $banners->gambar_upload);
            if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Upload gambar baru
            $image->move($path, $imageName);

            $banners->update([
                'judul' => $request->judul,
                'caption' => $request->caption,
                'gambar_upload' => $imageName,
            ]);
        } else {
            // Jika tidak ada gambar baru
            $banners->update([
                'judul' => $request->judul,
                'caption' => $request->caption,
            ]);
        }

        return redirect()->route('banners.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    public function destroy($id): RedirectResponse
    {
        $banners = Banner::findOrFail($id);
        $banners->delete();
        return redirect()->route('banners.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
