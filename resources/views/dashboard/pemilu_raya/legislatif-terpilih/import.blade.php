<?php

namespace App\Imports;

use App\Models\Legislatif;
use App\Models\LegislatifTerpilih;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class LegislatifTerpilihImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithValidation, WithChunkReading
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            // Langkah 1: Buat atau perbarui data caleg di tabel utama 'legislatifs'.
            // Ini akan mencari caleg berdasarkan nama lengkapnya. Jika sudah ada,
            // datanya akan diperbarui. Jika belum ada, data baru akan dibuat.
            $legislatif = Legislatif::updateOrCreate(
                [
                    // Kunci unik untuk mencari caleg
                    'nama_lengkap' => $row['nama_lengkap']
                ],
                [
                    // Data yang akan diisi atau diperbarui, sesuai migrasi Anda
                    'no_urut' => $row['no_urut'],
                    'nama_partai' => $row['nama_partai'],
                    'dapil' => $row['dapil'],
                    'suara_sah' => $row['suara_sah'],
                    'tempat_lahir' => $row['tempat_lahir'],
                    'jenis_kelamin' => ($row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'),
                    'riwayat_pendidikan' => $row['riwayat_pendidikan'],
                    'riwayat_pekerjaan' => $row['riwayat_pekerjaan'],
                ]
            );

            // Langkah 2: Tambahkan caleg tersebut ke daftar terpilih.
            // Metode updateOrCreate akan mencegah duplikasi jika caleg
            // sudah ada di dalam daftar terpilih.
            if ($legislatif) {
                LegislatifTerpilih::updateOrCreate(
                    [
                        'legislatif_id' => $legislatif->id,
                    ],
                    [
                        'jabatan' => $row['jabatan'] ?? null,
                    ]
                );
            }
        }
    }

    /**
     * Aturan validasi untuk setiap baris di file Excel.
     */
    public function rules(): array
    {
        return [
            '*.nama_lengkap' => 'required|string',
            '*.no_urut' => 'required|integer',
            '*.nama_partai' => 'required|string',
            '*.dapil' => 'required|string',
            '*.suara_sah' => 'required|integer',
        ];
    }

    public function chunkSize(): int
    {
        return 200;
    }
}
