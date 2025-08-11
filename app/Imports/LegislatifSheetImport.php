<?php

namespace App\Imports;

use App\Models\Legislatif;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

// PERUBAHAN: Kita menggunakan ToCollection untuk kontrol penuh
class LegislatifSheetImport implements ToCollection, WithHeadingRow, SkipsEmptyRows, WithValidation, WithChunkReading
{
    public function headingRow(): int
    {
        return 2;
    }

    /**
     * =================================================================
     * == FUNGSI SUPER PINTAR (ANTI DUPLIKAT) ==
     * =================================================================
     * Fungsi ini akan memproses setiap baris dari Excel secara manual
     * dan menggunakan metode updateOrCreate() yang paling andal.
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $cleanValue = function ($value) {
                $cleaned = trim($value ?? '');
                return in_array($cleaned, ['-', '']) ? null : $cleaned;
            };

            $jenisKelaminValue = strtoupper(trim($row['jenis_kelamin'] ?? null));
            $jenisKelamin = null;
            if ($jenisKelaminValue === 'L') {
                $jenisKelamin = 'Laki-laki';
            } elseif ($jenisKelaminValue === 'P') {
                $jenisKelamin = 'Perempuan';
            }

            // Mencari data berdasarkan kombinasi unik
            Legislatif::updateOrCreate(
                [
                    'dapil'       => $cleanValue($row['dapil']),
                    'nama_partai' => $cleanValue($row['nama_partai']),
                    'no_urut'     => $cleanValue($row['no_urut']),
                ],
                // Data yang akan diisi atau diperbarui
                [
                    'nama_lengkap'       => $cleanValue($row['nama_lengkap']),
                    'tempat_lahir'       => $cleanValue($row['tempat_lahir']),
                    'jenis_kelamin'      => $jenisKelamin,
                    'suara_sah'          => $cleanValue($row['suara_sah']) ?? 0,
                    'riwayat_pendidikan' => $cleanValue($row['riwayat_pendidikan']),
                    'riwayat_pekerjaan'  => $cleanValue($row['riwayat_pekerjaan']),
                ]
            );
        }
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => 'required|string',
            'dapil'        => 'required|string',
            'nama_partai'  => 'required|string',
            'no_urut'      => 'required|numeric',
        ];
    }
    
    public function chunkSize(): int
    {
        return 200;
    }
}
