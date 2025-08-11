<?php

namespace App\Imports;

use App\Models\PotensiKonflik;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PotensiKonflikImport implements ToModel, WithHeadingRow, WithValidation, WithStartRow
{
    public function headingRow(): int
    {
        return 3;
    }

    public function startRow(): int
    {
        return 5;
    }

    public function model(array $row)
    {
        // Debugging: uncomment baris di bawah untuk melihat isi array $row
        // dd($row);

        // --- Tambahan: Pengecekan Baris Kosong ---
        // Jika kolom kunci seperti 'nama_potensi_konflik' atau 'tanggal' kosong,
        // kemungkinan besar baris ini adalah baris kosong yang tidak diinginkan.
        // Kembalikan null agar Laravel Excel melewatkan baris ini.
        if (empty($row['nama_potensi_konflik']) && empty($row['tanggal'])) {
            return null;
        }
        // ------------------------------------------

        $tanggal = null;
        if (isset($row['tanggal'])) {
            if (is_numeric($row['tanggal'])) {
                $tanggal = Date::excelToDateTimeObject($row['tanggal']);
            } elseif (is_string($row['tanggal'])) {
                try {
                    $tanggal = Carbon::parse($row['tanggal']);
                } catch (\Exception $e) {
                    $tanggal = null;
                }
            }
        }

        return new PotensiKonflik([
            'nama_potensi' => $row['nama_potensi_konflik'],
            'kategori' => $row['kategori'],
            'lokasi_kecamatan' => $row['kecamatan'],
            'lokasi_kelurahan' => $row['kelurahan'],
            'alamat' => $row['alamat_lengkap'],
            'tanggal' => $tanggal,
            'tingkat_potensi' => strtolower($row['tingkat_potensi']),
            'deskripsi' => $row['deskripsi'],
            'status' => strtolower($row['status']),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.nama_potensi_konflik' => 'required|string|max:255',
            '*.kategori' => 'required|string|max:100',
            '*.kecamatan' => 'required|string|max:100',
            '*.kelurahan' => 'nullable|string|max:100',
            '*.alamat_lengkap' => 'required|string|min:10',
            '*.tanggal' => 'required',
            '*.tingkat_potensi' => 'required|in:rendah,sedang,tinggi,Rendah,Sedang,Tinggi',
            '*.status' => 'required|in:aktif,selesai,Aktif,Selesai',
            '*.deskripsi' => 'required|string|min:10',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.nama_potensi_konflik.required' => 'Kolom "Nama Potensi Konflik" wajib diisi.',
            '*.kategori.required' => 'Kolom "Kategori" wajib diisi.',
            '*.kecamatan.required' => 'Kolom "Kecamatan" wajib diisi.',
            '*.alamat_lengkap.required' => 'Kolom "Alamat Lengkap" wajib diisi.',
            '*.tanggal.required' => 'Kolom "Tanggal" wajib diisi.',
            '*.tingkat_potensi.required' => 'Kolom "Tingkat Potensi" wajib diisi.',
            '*.tingkat_potensi.in' => 'Nilai "Tingkat Potensi" harus Rendah, Sedang, atau Tinggi.',
            '*.deskripsi.required' => 'Kolom "Deskripsi" wajib diisi.',
            '*.status.required' => 'Kolom "Status" wajib diisi.',
            '*.status.in' => 'Nilai "Status" harus Aktif atau Selesai.',
        ];
    }
}