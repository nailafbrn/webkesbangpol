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
            // Langkah 1: Cari caleg yang sudah ada di database utama.
            $legislatif = Legislatif::where('nama_lengkap', $row['nama_lengkap'])->first();

            // Langkah 2: Jika caleg ditemukan, tambahkan ke daftar terpilih.
            // Metode updateOrCreate akan mencegah duplikasi jika caleg sudah ada di daftar terpilih.
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
            // Jika caleg tidak ditemukan di database utama, baris ini akan diabaikan karena validasi.
        }
    }

    /**
     * Aturan validasi untuk setiap baris di file Excel.
     */
    public function rules(): array
    {
        return [
            // Validasi hanya memerlukan nama lengkap dan memastikan nama tersebut ada di database utama.
            '*.nama_lengkap' => 'required|string|exists:legislatifs,nama_lengkap',
        ];
    }

    /**
     * Pesan error kustom jika validasi gagal.
     */
    public function customValidationMessages()
    {
        return [
            '*.nama_lengkap.exists' => 'Caleg dengan nama ":value" tidak ditemukan di database utama.',
        ];
    }

    public function chunkSize(): int
    {
        return 200;
    }
}