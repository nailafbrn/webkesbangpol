<?php

namespace App\Http\Controllers;

use App\Models\PotensiKonflik;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;


class PotensiKonflikController extends Controller
{
    public function index()
    {
        $potensiKonfliks = PotensiKonflik::orderBy('tanggal', 'desc')->paginate(10);
        return view('dashboard.potensi_konflik.index', compact('potensiKonfliks'));
    }

    public function create()
    {
        $kecamatanKelurahan = [
            'Andir' => [
                'Campaka',
                'Ciroyom',
                'Dunguscariang',
                'Garuda',
                'Kebonjeruk',
                'Maleber',
            ],
            'Antapani' => [
                'Antapani Kidul',
                'Antapani Kulon',
                'Antapani Tengah',
                'Antapani Wetan',
            ],
            'Arcamanik' => [
                'Cisaranten Bina Harapan',
                'Cisaranten Endah',
                'Cisaranten Kulon',
                'Sukamiskin',
            ],
            'Astanaanyar' => [
                'Cibadak',
                'Karanganyar',
                'Karasak',
                'Nyengseret',
                'Panjunan',
                'Pelindunghewan',
            ],
            'Babakan Ciparay' => [
                'Babakan Ciparay',
                'Cirangrang',
                'Margahayu Utara',
                'Margasuka',
                'Sukahaji',
                'Sukamulya',
            ],
            'Bandung Kidul' => [
                'Cijaura',
                'Mengger',
                'Wates',
            ],
            'Bandung Kulon' => [
                'Cijerah',
                'Cigondewah Kaler',
                'Cigondewah Kidul',
                'Cigondewah Rahayu',
                'Cigondewah Tengah',
                'Gempolsari',
                'Margahayu Utara',
                'Warung Muncang',
            ],
            'Bandung Wetan' => [
                'Cihapit',
                'Citarum',
                'Tamansari',
            ],
            'Batununggal' => [
                'Cibangkong',
                'Gumuruh',
                'Kebonwaru',
                'Kacapiring',
                'Maleer',
                'Samoja',
            ],
            'Bojongloa Kaler' => [
                'Babakan Asih',
                'Jamika',
                'Kebonlega',
                'Kopo',
                'Situsaeur',
            ],
            'Bojongloa Kidul' => [
                'Cibaduyut',
                'Cibaduyut Kidul',
                'Cibaduyut Wetan',
                'Mekarwangi',
                'Mulyasari',
                'Suka Asih',
            ],
            'Buahbatu' => [
                'Cijawura',
                'Jatisari',
                'Margasari',
                'Sekejati',
            ],
            'Cibeunying Kaler' => [
                'Cigadung',
                'Cihaurgeulis',
                'Neglasari',
                'Sukaluyu',
            ],
            'Cibeunying Kidul' => [
                'Cicadas',
                'Cikutra',
                'Padasuka',
                'Pasirlayung',
                'Sukamaju',
                'Sukapada',
            ],
            'Cibiru' => [
                'Cipadung',
                'Cisurupan',
                'Palasari',
                'Pasirbiru',
            ],
            'Cicendo' => [
                'Arjuna',
                'Husen Sastranegara',
                'Pajajaran',
                'Pamoyanan',
                'Pasirkaliki',
                'Sukaraja',
            ],
            'Cidadap' => [
                'Ciumbuleuit',
                'Hegarmanah',
                'Ledeng',
            ],
            'Cinambo' => [
                'Babakan Penghulu',
                'Cisaranten Wetan',
                'Pakemitan',
                'Sukamulya',
            ],
            'Coblong' => [
                'Cipaganti',
                'Dago',
                'Lebakgede',
                'Lebaksiliwangi',
                'Sadangserang',
                'Sekeloa',
            ],
            'Gedebage' => [
                'Cimincrang',
                'Cisaranten Kidul',
                'Rancabolang',
                'Rancanumpang',
            ],
            'Kiaracondong' => [
                'Babakansari',
                'Babakansurabaya',
                'Cicaheum',
                'Kebonkangkung',
                'Kebunjayanti',
                'Sukapura',
            ],
            'Lengkong' => [
                'Burangrang',
                'Cijagra',
                'Cikawao',
                'Lingkar Selatan',
                'Malabar',
                'Paledang',
                'Turangga',
            ],
            'Mandalajati' => [
                'Jatihandap',
                'Karangpamulang',
                'Pasir Impun',
                'Sindangjaya',
            ],
            'Panyileukan' => [
                'Cipadung Kidul',
                'Cipadung Kulon',
                'Cipadung Wetan',
                'Mekarmulya',
            ],
            'Rancasari' => [
                'Cipamokolan',
                'Darwati',
                'Manjahlega',
                'Mekarjaya',
            ],
            'Regol' => [
                'Ancol',
                'Balonggede',
                'Ciateul',
                'Cigereleng',
                'Ciseureuh',
                'Pasirluyu',
                'Pungkur',
            ],
            'Sukajadi' => [
                'Cipedes',
                'Pasteur',
                'Sukabungah',
                'Sukagalih',
                'Sukawarna',
            ],
            'Sukasari' => [
                'Gegerkalong',
                'Isola',
                'Sarijadi',
                'Sukarasa',
            ],
            'Sumur Bandung' => [
                'Babakanciamis',
                'Braga',
                'Kebonpisang',
                'Merdeka',
            ],
            'Ujungberung' => [
                'Cigending',
                'Pasanggrahan',
                'Pasirendah',
                'Pasirjati',
                'Pasirwangi',
            ],
        ];
        return view('dashboard.potensi_konflik.create', compact('kecamatanKelurahan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_potensi' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'lokasi_kecamatan' => 'required|string|max:100',
            'lokasi_kelurahan' => 'nullable|string|max:100',
            'alamat' => 'required|string|min:10',
            'tanggal' => 'required|date',
            'tingkat_potensi' => 'required|in:rendah,sedang,tinggi',
            'deskripsi' => 'required|string|min:10',
            'status' => 'required|in:aktif,selesai',
        ]);

        PotensiKonflik::create([
            'nama_potensi' => $request->nama_potensi,
            'kategori' => $request->kategori,
            'lokasi_kecamatan' => $request->lokasi_kecamatan,
            'lokasi_kelurahan' => $request->lokasi_kelurahan,
            'alamat' => Purifier::clean($request->alamat),
            'tanggal' => $request->tanggal,
            'tingkat_potensi' => $request->tingkat_potensi,
            'deskripsi' => Purifier::clean($request->deskripsi),
            'status' => $request->status,
        ]);

        return redirect()->route('potensi-konflik.index')->with('success', 'Data potensi konflik berhasil ditambahkan.');
    }

    public function show($id)
    {
        $potensiKonflik = PotensiKonflik::findOrFail($id);
        return view('dashboard.potensi_konflik.show', compact('potensiKonflik'));
    }

    public function edit($id)
    {
        $potensiKonflik = PotensiKonflik::findOrFail($id);
        $kecamatanKelurahan = [
            'Andir' => [
                'Campaka',
                'Ciroyom',
                'Dunguscariang',
                'Garuda',
                'Kebonjeruk',
                'Maleber',
            ],
            'Antapani' => [
                'Antapani Kidul',
                'Antapani Kulon',
                'Antapani Tengah',
                'Antapani Wetan',
            ],
            'Arcamanik' => [
                'Cisaranten Bina Harapan',
                'Cisaranten Endah',
                'Cisaranten Kulon',
                'Sukamiskin',
            ],
            'Astanaanyar' => [
                'Cibadak',
                'Karanganyar',
                'Karasak',
                'Nyengseret',
                'Panjunan',
                'Pelindunghewan',
            ],
            'Babakan Ciparay' => [
                'Babakan Ciparay',
                'Cirangrang',
                'Margahayu Utara',
                'Margasuka',
                'Sukahaji',
                'Sukamulya',
            ],
            'Bandung Kidul' => [
                'Cijaura',
                'Mengger',
                'Wates',
            ],
            'Bandung Kulon' => [
                'Cijerah',
                'Cigondewah Kaler',
                'Cigondewah Kidul',
                'Cigondewah Rahayu',
                'Cigondewah Tengah',
                'Gempolsari',
                'Margahayu Utara',
                'Warung Muncang',
            ],
            'Bandung Wetan' => [
                'Cihapit',
                'Citarum',
                'Tamansari',
            ],
            'Batununggal' => [
                'Cibangkong',
                'Gumuruh',
                'Kebonwaru',
                'Kacapiring',
                'Maleer',
                'Samoja',
            ],
            'Bojongloa Kaler' => [
                'Babakan Asih',
                'Jamika',
                'Kebonlega',
                'Kopo',
                'Situsaeur',
            ],
            'Bojongloa Kidul' => [
                'Cibaduyut',
                'Cibaduyut Kidul',
                'Cibaduyut Wetan',
                'Mekarwangi',
                'Mulyasari',
                'Suka Asih',
            ],
            'Buahbatu' => [
                'Cijawura',
                'Jatisari',
                'Margasari',
                'Sekejati',
            ],
            'Cibeunying Kaler' => [
                'Cigadung',
                'Cihaurgeulis',
                'Neglasari',
                'Sukaluyu',
            ],
            'Cibeunying Kidul' => [
                'Cicadas',
                'Cikutra',
                'Padasuka',
                'Pasirlayung',
                'Sukamaju',
                'Sukapada',
            ],
            'Cibiru' => [
                'Cipadung',
                'Cisurupan',
                'Palasari',
                'Pasirbiru',
            ],
            'Cicendo' => [
                'Arjuna',
                'Husen Sastranegara',
                'Pajajaran',
                'Pamoyanan',
                'Pasirkaliki',
                'Sukaraja',
            ],
            'Cidadap' => [
                'Ciumbuleuit',
                'Hegarmanah',
                'Ledeng',
            ],
            'Cinambo' => [
                'Babakan Penghulu',
                'Cisaranten Wetan',
                'Pakemitan',
                'Sukamulya',
            ],
            'Coblong' => [
                'Cipaganti',
                'Dago',
                'Lebakgede',
                'Lebaksiliwangi',
                'Sadangserang',
                'Sekeloa',
            ],
            'Gedebage' => [
                'Cimincrang',
                'Cisaranten Kidul',
                'Rancabolang',
                'Rancanumpang',
            ],
            'Kiaracondong' => [
                'Babakansari',
                'Babakansurabaya',
                'Cicaheum',
                'Kebonkangkung',
                'Kebunjayanti',
                'Sukapura',
            ],
            'Lengkong' => [
                'Burangrang',
                'Cijagra',
                'Cikawao',
                'Lingkar Selatan',
                'Malabar',
                'Paledang',
                'Turangga',
            ],
            'Mandalajati' => [
                'Jatihandap',
                'Karangpamulang',
                'Pasir Impun',
                'Sindangjaya',
            ],
            'Panyileukan' => [
                'Cipadung Kidul',
                'Cipadung Kulon',
                'Cipadung Wetan',
                'Mekarmulya',
            ],
            'Rancasari' => [
                'Cipamokolan',
                'Darwati',
                'Manjahlega',
                'Mekarjaya',
            ],
            'Regol' => [
                'Ancol',
                'Balonggede',
                'Ciateul',
                'Cigereleng',
                'Ciseureuh',
                'Pasirluyu',
                'Pungkur',
            ],
            'Sukajadi' => [
                'Cipedes',
                'Pasteur',
                'Sukabungah',
                'Sukagalih',
                'Sukawarna',
            ],
            'Sukasari' => [
                'Gegerkalong',
                'Isola',
                'Sarijadi',
                'Sukarasa',
            ],
            'Sumur Bandung' => [
                'Babakanciamis',
                'Braga',
                'Kebonpisang',
                'Merdeka',
            ],
            'Ujungberung' => [
                'Cigending',
                'Pasanggrahan',
                'Pasirendah',
                'Pasirjati',
                'Pasirwangi',
            ],
        ];
        return view('dashboard.potensi_konflik.edit', compact('potensiKonflik', 'kecamatanKelurahan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_potensi' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'lokasi_kecamatan' => 'required|string|max:100',
            'lokasi_kelurahan' => 'nullable|string|max:100',
            'alamat' => 'required|string|min:10',
            'tanggal' => 'required|date',
            'tingkat_potensi' => 'required|in:rendah,sedang,tinggi',
            'deskripsi' => 'required|string|min:10',
            'status' => 'required|in:aktif,selesai',
        ]);

        $potensiKonflik = PotensiKonflik::findOrFail($id);
        $potensiKonflik->update([
            'nama_potensi' => $request->nama_potensi,
            'kategori' => $request->kategori,
            'lokasi_kecamatan' => $request->lokasi_kecamatan,
            'lokasi_kelurahan' => $request->lokasi_kelurahan,
            'alamat' => Purifier::clean($request->alamat),
            'tanggal' => $request->tanggal,
            'tingkat_potensi' => $request->tingkat_potensi,
            'deskripsi' => Purifier::clean($request->deskripsi),
            'status' => $request->status,
        ]);

        return redirect()->route('potensi-konflik.index')->with('success', 'Data potensi konflik berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $potensiKonflik = PotensiKonflik::findOrFail($id);
        $potensiKonflik->delete();

        return redirect()->route('potensi-konflik.index')->with('success', 'Data potensi konflik berhasil dihapus.');
    }
}
