<?php

namespace App\Imports;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class YayasanImport implements ToCollection
{
    protected $data = [];
    protected $debug = false;

    public function collection(Collection $rows)
    {
        $dataOrmas = [];
        $currentTahun = null;
        $currentHeaders = [];
        $foundJudul = false;
        $foundBadanTitle = false;
        $currentOrganisasi = null;
        $pengurusIndex = -1; // Index untuk melacak organisasi saat ini

        foreach ($rows as $rowIndex => $row) {

            // 1) Lewati baris kosong
            if ($row->filter()->isEmpty()) {
                continue;
            }

            // 2) Skip SELURUH baris jika ada sel yang gaya penulisannya formula (awal =)
            foreach ($row as $cell) {
                if (Str::startsWith(trim((string) $cell), '=')) {
                    // dump("Skip baris $rowIndex karena ada formula: " . trim((string)$cell));
                    continue 2;  // <-- lompat ke row berikutnya
                }
            }

            // Deteksi awal baris judul fleksibel
            if (!$foundJudul) {
                // Gabungkan semua nilai sel dalam satu baris menjadi string tunggal
                $rowContent = '';
                foreach ($row as $cell) {
                    $rowContent .= trim((string)$cell) . ' ';
                }
                $rowContent = trim($rowContent);
                
                // Perbaikan: Lebih fleksibel dalam mendeteksi judul
                if (preg_match('/DATA\s+ORGANISASI/i', $rowContent)) {
                    // dump("Judul Ditemukan: $rowContent");
                    $foundJudul = true;
                    continue;
                }
            }

            // Deteksi judul "BADAN KESATUAN BANGSA DAN POLITIK KOTA BANDUNG"
            if ($foundJudul && !$foundBadanTitle) {
                $rowContent = '';
                foreach ($row as $cell) {
                    $rowContent .= trim((string)$cell) . ' ';
                }
                $rowContent = trim($rowContent);
                
                // Perbaikan: Deteksi lebih fleksibel untuk judul badan
                if (preg_match('/BADAN\s+KESATUAN/i', $rowContent)) {
                    // dump("Badan Title Ditemukan: $rowContent");
                    $foundBadanTitle = true;
                    continue;
                }
            }

            // Deteksi tahun: pola "TAHUN 2017" - sekarang memeriksa seluruh baris
            if ($foundJudul && $foundBadanTitle) {
                $firstCell = isset($row[0]) ? trim((string)$row[0]) : '';
                
                // Perbaikan: Deteksi tahun lebih fleksibel
                if (preg_match('/TAHUN\s+(\d{4})/i', $firstCell, $match)) {
                    $currentTahun = $match[1];
                    $currentHeaders = []; // Reset header karena kemungkinan struktur tabel berubah
                    
                    // dump("Tahun terdeteksi: $currentTahun");
                    continue;
                }
            }

            // Perbaikan: Deteksi header kolom lebih fleksibel
            if (
                isset($row[0]) && preg_match('/NO/i', trim((string)$row[0])) &&
                isset($row[2]) && preg_match('/NAMA\s+ORGANISASI/i', trim((string)$row[2]))
            ) {
                $currentHeaders = $row->toArray();
                continue;
            }

            // Skip baris dengan hanya angka saja setelah header
            if ($currentHeaders) {
                $firstCell = isset($row[0]) ? trim((string)$row[0]) : '';
                
                // Deteksi nomor yang mungkin diformat sebagai "1.", "1", dll
                if (preg_match('/^[\d\.]+$/', $firstCell) && strlen($firstCell) <= 3) {
                    // Cek apakah ini adalah baris yang berisi angka kolom (1, 2, 3, 4, ...)
                    $isNumericRow = true;
                    $cellCount = 0;
                    
                    foreach ($row as $cellIndex => $cell) {
                        $cellContent = trim((string)$cell);
                        if (!empty($cellContent)) {
                            $cellCount++;
                            if (!is_numeric($cellContent) && !preg_match('/^[\d\.]+$/', $cellContent)) {
                                $isNumericRow = false;
                                break;
                            }
                        }
                    }
                    
                    // Jika baris hanya berisi nomor dan memiliki setidaknya 3 sel, skip
                    if ($isNumericRow && $cellCount >= 3) {
                        // dump("Melewati baris nomor kolom: " . implode(", ", array_map(function($cell) {
                        //     return trim((string)$cell);
                        // }, $row->toArray())));
                        continue; 
                    }
                }
            }

            // Simpan data jika header dan tahun sudah terdeteksi
            if ($currentTahun) {
                $firstCell = isset($row[0]) ? trim((string)$row[0]) : '';
                
                // Deteksi baris data organisasi (baris dengan nomor di kolom pertama)
                if (!empty($firstCell) && preg_match('/^\d+$/', $firstCell)) {
                    
                    // Ini adalah baris data utama organisasi (dengan ketua)
                    $pengurusIndex++;

                    // --- CEK SKIP JIKA ADA FIELD DIMULAI DENGAN "=" ---
                    $rawFields = [
                        'nama_organisasi' => $row[2] ?? '',
                        'alamat'          => $row[3] ?? '',
                        'pengurus'        => $row[4] ?? '',
                        'akta'            => $row[5] ?? '',
                        'ahu_skt'         => $row[6] ?? '',
                        'bidang'          => $row[7] ?? '',
                        'npwp'            => $row[9] ?? '',
                    ];
                    foreach ($rawFields as $fieldName => $rawValue) {
                        if (strpos(trim((string)$rawValue), '=') === 0) {
                            // jump keluar 2 level loop: skip row ini seluruhnya
                            continue 2;
                        }
                    }

                    // --- CEK WAJIB: NAMA, ALAMAT, BIDANG tidak boleh kosong ---
                    $namaOrmas = trim((string)($row[2] ?? ''));
                    $alamat    = trim((string)($row[3] ?? ''));
                    $bidang    = trim((string)($row[7] ?? ''));
                    
                    if (empty($namaOrmas) || empty($alamat) || empty($bidang)) {
                        // Skip baris karena kolom penting kosong
                        Log::debug("Skip baris {$firstCell} karena kolom wajib kosong: ", [
                            'nama_organisasi' => $namaOrmas,
                            'alamat' => $alamat,
                            'bidang' => $bidang,
                        ]);
                        continue;
                    }
            
                    // Extract pengurus data from column 5 (index 4)
                    $pengurusData = isset($row[4]) ? trim((string)$row[4]) : '';
                    
                    $currentOrganisasi = [
                        'nama_organisasi' => $this->cleanText($row[2] ?? null),
                        'alamat' => $this->cleanText($row[3] ?? null),
                        'akta'     => $this->formatNomorTanggal($row[5] ?? null),
                        'ahu_skt'  => $this->formatNomorTanggal($row[6] ?? null),
                        'bidang' => $this->cleanText($row[7] ?? null),
                        'npwp' => $this->cleanText($row[9] ?? null),
                        'pengurus' => []
                    ];
                    
                    // Tambahkan data ketua
                    $namaKetua = $this->extractKetuaName($pengurusData);
                    $teleponKetua = isset($row[8]) ? trim((string)$row[8]) : null;
                    
                    if ($namaKetua) {
                        $currentOrganisasi['pengurus'][] = [
                            'jabatan' => 'ketua',
                            'nama' => $namaKetua,
                            'telepon' => $teleponKetua
                        ];
                    }
                    
                    $dataOrmas[$pengurusIndex] = $currentOrganisasi;
                }
                // Perbaikan: Deteksi data pengurus tambahan (sekretaris, bendahara)
                elseif (
                    empty($firstCell) && 
                    $pengurusIndex >= 0 &&
                    isset($dataOrmas[$pengurusIndex])
                ) {
                    $pengurusData = isset($row[4]) ? trim((string)$row[4]) : '';
                    
                    // Jika kolom pengurus tidak kosong
                    if (!empty($pengurusData)) {
                        $teleponData = isset($row[8]) ? trim((string)$row[8]) : null;
                        
                        // Deteksi sekretaris berdasarkan format "S: [nama]" atau "S : [nama]"
                        if (preg_match('/^S\s*[:\.](.+)$/i', $pengurusData, $matches)) {
                            $namaSekretaris = trim($matches[1]);
                            
                            if ($namaSekretaris) {
                                $dataOrmas[$pengurusIndex]['pengurus'][] = [
                                    'jabatan' => 'sekretaris',
                                    'nama' => $namaSekretaris,
                                    'telepon' => $teleponData
                                ];
                            }
                        }
                        
                        // Deteksi bendahara berdasarkan format "B: [nama]" atau "B : [nama]"
                        if (preg_match('/^B\s*[:\.](.+)$/i', $pengurusData, $matches)) {
                            $namaBendahara = trim($matches[1]);
                            
                            if ($namaBendahara) {
                                $dataOrmas[$pengurusIndex]['pengurus'][] = [
                                    'jabatan' => 'bendahara',
                                    'nama' => $namaBendahara,
                                    'telepon' => $teleponData
                                ];
                            }
                        }
                    }
                }
            }
        }
        
        // Simpan data untuk debugging
        $this->data = $dataOrmas;
        
        // Kode di bawah tidak akan dieksekusi karena dd() menghentikan eksekusi
        return $dataOrmas;
    }

    // Method untuk mendapatkan data yang telah diproses (untuk debugging)
    public function getCollectedData()
    {
        return $this->data;
    }

    // ===============================================================================================================================


    // Membersihkan apostrof Excel, double space, dan trim
    protected function cleanText(?string $text): ?string
    {
        if ($text === null) {
            return null;
        }

        // Hapus apostrof Excel di depan (jika ada)
        $text = preg_replace("/^'+/", '', (string) $text);

        // Trim & normalisasi spasi
        $text = trim($text);
        $text = preg_replace('/\s+/', ' ', $text);

        return $text !== '' ? $text : null;
    }


    protected function formatNomorTanggal(?string $input): ?string
    {
        if (!$input) {
            return null;
        }

        // Hapus spasi ganda dan trim
        $clean = preg_replace('/\s+/', ' ', trim($input));
        $nomor = null;
        $tanggal = null;

        // 1) Deteksi nomor: hanya angka (dengan huruf atau simbol pendukung) setelah prefix Nomor/No/AHU
        if (preg_match(
            '/\b(?:Nomor|No\.?|No|AHU)[\s:\.\-]*([A-Za-z0-9\-\/\.]+)(?=\s|,|$)/i',
            $clean,
            $mNomor
        )) {
            $nomor = trim($mNomor[1]);
        }

        // 2) Deteksi tanggal: dd MMMM yyyy
        if (preg_match(
            '/\b(\d{1,2}\s+\w+\s+\d{4})\b/u',
            $clean,
            $mTgl
        )) {
            $tanggal = trim($mTgl[1]);
        }

        // Format hasil
        if ($nomor && $tanggal) {
            return "Nomor: {$nomor}, Tanggal: {$tanggal}";
        } elseif ($nomor) {
            return "Nomor: {$nomor}";
        } elseif ($tanggal) {
            return "Tanggal: {$tanggal}";
        }

        // fallback
        return $clean;
    }

    // Fungsi untuk mengekstrak nama ketua dari kolom pengurus
    protected function extractKetuaName(string $input): ?string
    {
        // Tangkap awalan “K” (bisa uppercase/lowercase), spasi opsional, titik dua, lalu nama hingga koma atau akhir string
        if (preg_match('/\bK\s*:\s*(.*?)(?:,|$)/iu', $input, $matches)) {
            return trim($matches[1]);
        }
        
        // Kalau format “Ketua” lengkap
        if (preg_match('/\bKetua\s*:\s*(.*?)(?:,|$)/iu', $input, $matches)) {
            return trim($matches[1]);
        }

        // Fallback: kembalikan seluruh string jika bukan format prefiks
        return trim($input) !== '' ? trim($input) : null;
    }

    // Fungsi untuk mengekstrak nama sekretaris dari kolom pengurus
    protected function extractSekretarisName(string $input): ?string
    {
        if (preg_match('/\bS\s*:\s*(.*?)(?:,|$)/iu', $input, $matches)) {
            return trim($matches[1]);
        }
        if (preg_match('/\bSekretaris\s*:\s*(.*?)(?:,|$)/iu', $input, $matches)) {
            return trim($matches[1]);
        }

        return trim($input) !== '' ? trim($input) : null;
    }

    // Fungsi untuk mengekstrak nama bendahara dari kolom pengurus
    protected function extractBendaharaName(string $input): ?string
    {
        if (preg_match('/\bB\s*:\s*(.*?)(?:,|$)/iu', $input, $matches)) {
            return trim($matches[1]);
        }
        if (preg_match('/\bBendahara\s*:\s*(.*?)(?:,|$)/iu', $input, $matches)) {
            return trim($matches[1]);
        }

        return trim($input) !== '' ? trim($input) : null;
    }


    // Fungsi untuk mengekstrak telepon ketua (biasanya baris pertama)
    protected function extractKetuaPhone(string $input): ?string
    {
        // Jika ada beberapa nomor (dipisahkan baris baru), ambil yang pertama
        $lines = preg_split('/\r\n|\r|\n/', trim($input));
        return !empty($lines[0]) ? trim($lines[0]) : null;
    }

    // Fungsi untuk mengekstrak telepon sekretaris
    protected function extractSekretarisPhone(string $input): ?string
    {
        // Jika ada beberapa nomor (dipisahkan baris baru), ambil yang kedua
        $lines = preg_split('/\r\n|\r|\n/', trim($input));
        return isset($lines[1]) && !empty($lines[1]) ? trim($lines[1]) : null;
    }

    // Fungsi untuk mengekstrak telepon bendahara
    protected function extractBendaharaPhone(string $input): ?string
    {
        // Jika ada beberapa nomor (dipisahkan baris baru), ambil yang ketiga
        $lines = preg_split('/\r\n|\r|\n/', trim($input));
        return isset($lines[2]) && !empty($lines[2]) ? trim($lines[2]) : null;
    }
}