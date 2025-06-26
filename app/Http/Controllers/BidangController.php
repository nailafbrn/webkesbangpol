<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Bidang;
use Illuminate\Http\RedirectResponse;

class BidangController extends Controller
{
    //
    public function index(): View
    {
        $count = Bidang::count();
        $bidangs = Bidang::latest()->paginate(5);
        return view('dashboard.bidangs.index', compact('bidangs'));
    }

    public function create(): View
    {
        return view('dashboard.bidangs.create');
    }

    public function store(Request $request): RedirectResponse
    {
    // Validasi input
    $request->validate([
        'no_bidang' => 'required|string|max:255|unique:bidangs,no_bidang',
        'nama_bidang' => 'required|string|max:255',
    ]);

    // Simpan ke database
    Bidang::create([
        'no_bidang' => $request->no_bidang,
        'nama_bidang' => $request->nama_bidang,
    ]);

    // Redirect dengan notifikasi sukses
    return redirect()->route('bidangs.index')->with('success', 'Data bidang berhasil ditambahkan.');
    }

    // Fungsi untuk menampilkan halaman edit
    public function edit($id): View
    {
        // Ambil data bidang berdasarkan ID
        $bidang = Bidang::findOrFail($id);
        
        // Kembalikan halaman edit dengan data bidang
        return view('dashboard.bidangs.edit', compact('bidang'));
    }

    // Fungsi untuk memperbarui data bidang
    public function update(Request $request, $id): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'no_bidang' => 'required|string|max:255|unique:bidangs,no_bidang,' . $id, // Pastikan no_bidang tetap unik kecuali pada ID yang sama
            'nama_bidang' => 'required|string|max:255',
        ]);

        // Cari data bidang berdasarkan ID
        $bidang = Bidang::findOrFail($id);

        // Update data bidang
        $bidang->update([
            'no_bidang' => $request->no_bidang,
            'nama_bidang' => $request->nama_bidang,
        ]);

        // Redirect dengan notifikasi sukses
        return redirect()->route('bidangs.index')->with('success', 'Data bidang berhasil diperbarui.');
    }

}
