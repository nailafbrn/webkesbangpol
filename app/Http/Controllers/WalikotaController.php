<?php

namespace App\Http\Controllers;

use App\Models\Paslon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WalikotaController extends Controller
{
    /**
     * Membersihkan input angka dari format titik/koma.
     */
    private function cleanNumber($value)
    {
        return (int) preg_replace('/[^0-9]/', '', $value);
    }

    public function index()
    {
        $paslons = Paslon::where('jenis_pemilu', 'walikota')->orderBy('no_urut', 'asc')->get();
        return view('dashboard.pemilu_raya.walikota.index', compact('paslons'));
    }

    public function create()
    {
        return view('dashboard.pemilu_raya.walikota.create');
    }

    public function store(Request $request)
    {
        // Menyesuaikan logika dari PilpresController: Hanya membersihkan total_suara
        $request->merge([
            'total_suara' => $this->cleanNumber($request->input('total_suara')),
        ]);

        // Menyesuaikan logika dari PilpresController: Validasi disamakan
        $validatedData = $request->validate([
                        'no_urut' => [
                'required',
                'integer',
                Rule::unique('paslons')->where(function ($query) use ($request) {
                    return $query->where('jenis_pemilu', 'walikota')
                                 ->where('tahun_pemilu', $request->tahun_pemilu);
                })
            ],
            'tahun_pemilu' => 'required|digits:4',
            'partai_pengusung' => 'required|string|max:255',
            'total_suara' => 'nullable|integer|min:0',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'capres_nama' => 'required|string|max:255',
            'capres_foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'capres_tempat_lahir' => 'required|string|max:255',
            'capres_tanggal_lahir' => 'required|date',
            'capres_jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'capres_riwayat_pendidikan' => 'nullable|string',
            'capres_riwayat_pekerjaan' => 'nullable|string',
            'cawapres_nama' => 'nullable|string|max:255',
            'cawapres_foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cawapres_tempat_lahir' => 'nullable|string|max:255',
            'cawapres_tanggal_lahir' => 'nullable|date',
            'cawapres_jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'cawapres_riwayat_pendidikan' => 'nullable|string',
            'cawapres_riwayat_pekerjaan' => 'nullable|string',
        ]);

        $validatedData['jenis_pemilu'] = 'walikota';
        
        $uploadPath = 'images/pemilu';
        if ($request->hasFile('capres_foto')) {
            $file = $request->file('capres_foto');
            $filename = time() . '_capres_' . $file->hashName();
            $file->move(public_path($uploadPath), $filename);
            $validatedData['capres_foto'] = $uploadPath . '/' . $filename;
        }
        if ($request->hasFile('cawapres_foto')) {
            $file = $request->file('cawapres_foto');
            $filename = time() . '_cawapres_' . $file->hashName();
            $file->move(public_path($uploadPath), $filename);
            $validatedData['cawapres_foto'] = $uploadPath . '/' . $filename;
        }

        Paslon::create($validatedData);
        // Menyesuaikan redirect route
        return redirect()->route('admin.pemilu.walikota.index')->with('success', 'Data Paslon Wali Kota berhasil ditambahkan.');
    }

    public function show($id)
    {
        $paslon = Paslon::findOrFail($id);
        return view('dashboard.pemilu_raya.walikota.show', compact('paslon'));
    }

    public function edit($id)
    {
        $paslon = Paslon::findOrFail($id);
        return view('dashboard.pemilu_raya.walikota.edit', compact('paslon'));
    }

    public function update(Request $request, $id)
    {
        // Menyesuaikan logika dari PilpresController: Hanya membersihkan total_suara
        $request->merge([
            'total_suara' => $this->cleanNumber($request->input('total_suara')),
        ]);

        $paslon = Paslon::findOrFail($id);

        // Menyesuaikan logika dari PilpresController: Validasi disamakan
        $validatedData = $request->validate([
            'no_urut' => ['required', 'integer', Rule::unique('paslons')->ignore($paslon->id)->where(fn ($query) => $query->where('jenis_pemilu', 'walikota')->where('tahun_pemilu', $request->tahun_pemilu))],
            'tahun_pemilu' => 'required|digits:4',
            'partai_pengusung' => 'required|string|max:255',
            'total_suara' => 'nullable|integer|min:0',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'capres_nama' => 'required|string|max:255',
            'capres_foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'capres_tempat_lahir' => 'required|string|max:255',
            'capres_tanggal_lahir' => 'required|date',
            'capres_jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'capres_riwayat_pendidikan' => 'nullable|string',
            'capres_riwayat_pekerjaan' => 'nullable|string',
            'cawapres_nama' => 'nullable|string|max:255',
            'cawapres_foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cawapres_tempat_lahir' => 'nullable|string|max:255',
            'cawapres_tanggal_lahir' => 'nullable|date',
            'cawapres_jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'cawapres_riwayat_pendidikan' => 'nullable|string',
            'cawapres_riwayat_pekerjaan' => 'nullable|string',
        ]);

        $uploadPath = 'images/pemilu';
        if ($request->hasFile('capres_foto')) {
            if ($paslon->capres_foto && file_exists(public_path($paslon->capres_foto))) unlink(public_path($paslon->capres_foto));
            $file = $request->file('capres_foto');
            $filename = time() . '_capres_' . $file->hashName();
            $file->move(public_path($uploadPath), $filename);
            $validatedData['capres_foto'] = $uploadPath . '/' . $filename;
        }
        if ($request->hasFile('cawapres_foto')) {
            if ($paslon->cawapres_foto && file_exists(public_path($paslon->cawapres_foto))) unlink(public_path($paslon->cawapres_foto));
            $file = $request->file('cawapres_foto');
            $filename = time() . '_cawapres_' . $file->hashName();
            $file->move(public_path($uploadPath), $filename);
            $validatedData['cawapres_foto'] = $uploadPath . '/' . $filename;
        }

        $paslon->update($validatedData);
        // Menyesuaikan redirect route
        return redirect()->route('admin.pemilu.walikota.index')->with('success', 'Data Paslon Wali Kota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $paslon = Paslon::findOrFail($id);
        if ($paslon->capres_foto && file_exists(public_path($paslon->capres_foto))) unlink(public_path($paslon->capres_foto));
        if ($paslon->cawapres_foto && file_exists(public_path($paslon->cawapres_foto))) unlink(public_path($paslon->cawapres_foto));
        $paslon->delete();
        // Menyesuaikan redirect route
        return redirect()->route('admin.pemilu.walikota.index')->with('success', 'Data Paslon Wali Kota berhasil dihapus.');
    }
}
