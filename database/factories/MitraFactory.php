<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use App\Models\Mitra;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mitra>
 */
class MitraFactory extends Factory
{
    protected $model = Mitra::class;

    public function definition(): array
    {
        $kategoriList = ['FORKOPIMDA', 'KPU', 'BAWASLU', 'BNN', 'PARPOL', 'FKDM', 'FKUB', 'FPK'];
        $kategori = $this->faker->randomElement($kategoriList);

        $namaLembagaContoh = [
            'FORKOPIMDA' => [
                'Forum Komunikasi Pimpinan Daerah (FORKOPIMDA) Kota Bandung'
            ],
            'KPU' => [
                'Komisi Pemilihan Umum (KPU) Kota Bandung'
            ],
            'BAWASLU' => [
                'Badan Pengawas Pemilu (BAWASLU) Kota Bandung'
            ],
            'BNN' => [
                'Badan Narkotika Nasional (BNN) Kota Bandung'
            ],
            'PARPOL' => [
                'Partai Keadilan Sejahtera (PKS)',
                'Partai Gerakan Indonesia Raya (Gerindra)',
                'Partai Golongan Karya (Golkar)',
                'Partai Demokrasi Indonesia Perjuangan (PDI‑P)',
                'Partai Nasional Demokrat (NasDem)',
                'Partai Kebangkitan Bangsa (PKB)',
                'Partai Solidaritas Indonesia (PSI)',
                'Partai Demokrat'
            ],
            'FKDM' => [
                'Forum Kewaspadaan Dini Masyarakat (FKDM) Kota Bandung'
            ],
            'FKUB' => [
                'Forum Kerukunan Umat Beragama (FKUB) Kota Bandung'
            ],
            'FPK' => [
                'Forum Pembauran Kebangsaan (FPK) Kota Bandung'
            ],
        ];

        return [
            'kategori_mitra' => $kategori,
            'logo_lembaga' => 'image-template.webp',
            'nama_lembaga' => $this->faker->randomElement($namaLembagaContoh[$kategori]),
            'alamat' => $this->faker->address(),
            'deskripsi' => $this->faker->paragraph(3),
            'ketua' => $this->faker->name(),
            'foto_ketua' => 'profile-template.webp',
            'kontak' => $this->faker->phoneNumber() . ' / ' . $this->faker->email(),
        ];
    }
}

