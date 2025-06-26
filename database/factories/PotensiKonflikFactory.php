<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PotensiKonflik>
 */
class PotensiKonflikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $kecamatanKelurahan = [
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

    public function definition(): array
    {
        $kecamatan = $this->faker->randomElement(array_keys($this->kecamatanKelurahan));
        $kelurahan = $this->faker->randomElement($this->kecamatanKelurahan[$kecamatan]);

        $tingkatPotensi = ['rendah', 'sedang', 'tinggi'];
        $status = ['aktif', 'selesai'];

        return [
            'nama_potensi' => $this->faker->sentence(3),
            'kategori' => $this->faker->randomElement(['Sosial', 'Ekonomi', 'Politik', 'Lingkungan', 'Agama']),
            'lokasi_kecamatan' => $kecamatan,
            'lokasi_kelurahan' => $kelurahan,
            'tanggal' => $this->faker->dateTimeBetween('2020-01-01', '2024-12-31')->format('Y-m-d'),
            'tingkat_potensi' => $this->faker->randomElement($tingkatPotensi),
            'deskripsi' => $this->faker->paragraph(3),
            'status' => $this->faker->randomElement($status),
        ];
    }
}
