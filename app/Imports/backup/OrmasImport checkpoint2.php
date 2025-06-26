<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;

// Tabel ormas ['id','nama_organisasi','alamat','bidang','sumber_data (enum: verif, lsm, yayasan)','tanggal_verifikasi', timestamp]
// Tabel pengurus_ormas ['id','ormas_id','jabatan (enum: Ketua, Sekretaris, Bendahara)','nama','no_telepon']
// Tabel dokumen ['id','ormas_id','no_akta_notaris','tgl_akta_notaris','no_ahu_skt','tgl_ahu_skt']

class OrmasImport implements ToCollection
{
    protected $data = [];
    protected $debug = false;

    public function __construct($debug = false)
    {
        $this->debug = $debug;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $dataOrmas = [];
        $currentBulan = null;
        $currentTahun = null;
        $currentHeaders = [];
        $foundJudul = false;
        $currentOrganisasi = null;
        $pengurusIndex = -1; // Index untuk melacak organisasi saat ini

        foreach ($rows as $row) {
            $firstCell = trim((string) $row[0]);

            // Lewati baris kosong
            if ($row->filter()->isEmpty()) continue;
            
            // Deteksi awal baris judul fleksibel
            if (!$foundJudul) {
                // Gabungkan semua nilai sel dalam satu baris menjadi string tunggal
                $rowContent = '';
                foreach ($row as $cell) {
                    $rowContent .= trim((string)$cell) . ' ';
                }
                $rowContent = trim($rowContent);
                
                // Cek apakah ada pola "DAFTAR ORGANISASI" di baris tersebut
                if (preg_match('/DAFTAR\s+ORGANISASI/i', $rowContent)) {
                    // dump("Judul Ditemukan: $rowContent");
                    $foundJudul = true;
                    continue;
                }
            }

            // Deteksi baris "BULAN: ..."
            if ($foundJudul) {
                // Gabungkan semua nilai sel dalam satu baris menjadi string tunggal untuk pemeriksaan
                $rowContent = '';
                foreach ($row as $cell) {
                    $rowContent .= trim((string)$cell) . ' ';
                }
                $rowContent = trim($rowContent);
                
                // Deteksi pola "BULAN: [nama bulan] [tahun]" dengan berbagai variasi
                if (preg_match('/BULAN\s*:?\s*([A-Za-z]+)\s+(\d{4})/i', $rowContent, $match)) {
                    $currentBulan = ucfirst(strtolower($match[1]));
                    $currentTahun = $match[2];
                    $currentHeaders = []; // Reset header karena kemungkinan struktur tabel berubah
                    
                    // dump("Bulan terdeteksi: $currentBulan $currentTahun");
                    continue;
                }
            }

            // Deteksi header kolom baru
            if (
                preg_match('/No/i', $firstCell) &&
                isset($row[2]) && stripos((string)$row[2], 'Nama Organisasi') !== false
            ) {
                $currentHeaders = $row->toArray();
                continue;
            }

            // Simpan data jika header dan bulan sudah terdeteksi
            if ($currentHeaders && $currentBulan && $currentTahun) {
                // Jika baris berisi nomor organisasi, ini adalah data organisasi baru
                if (!empty(trim((string)$row[0])) && preg_match('/^\d+\.?$/', trim((string)$row[0]))) {
                    // Ini adalah baris data utama organisasi (dengan ketua)
                    $pengurusIndex++;
                    
                    $currentOrganisasi = [
                        'bulan' => $currentBulan,
                        'tahun' => $currentTahun,
                        'no' => isset($row[0]) ? trim((string)$row[0]) : null,
                        // 'tanggal' => isset($row[1]) ? $this->formatExcelDate(trim((string)$row[1])) : null,
                        'nama_organisasi' => isset($row[2]) ? trim((string)$row[2]) : null,
                        'alamat' => isset($row[3]) ? trim((string)$row[3]) : null,
                        'akta' => isset($row[5]) ? trim((string)$row[5]) : null,
                        'ahu_skt' => isset($row[6]) ? trim((string)$row[6]) : null,
                        'bidang' => isset($row[7]) ? trim((string)$row[7]) : null,
                        'npwp' => isset($row[9]) ? trim((string)$row[9]) : null,
                        'pengurus' => []
                    ];
                    
                    // Tambahkan data ketua
                    $namaKetua = $this->extractKetuaName($row[4] ?? '');
                    $teleponKetua = $this->extractKetuaPhone($row[8] ?? '');
                    
                    if ($namaKetua) {
                        $currentOrganisasi['pengurus'][] = [
                            'jabatan' => 'ketua',
                            'nama' => $namaKetua,
                            'telepon' => $teleponKetua
                        ];
                    }
                    
                    $dataOrmas[$pengurusIndex] = $currentOrganisasi;
                }
                // Jika baris tidak memiliki nomor tapi kolom nama pengurus (4) dan telepon (8) diisi
                // Ini kemungkinan baris untuk sekretaris (baris kedua) atau bendahara (baris ketiga)
                elseif (
                    empty(trim((string)$row[0])) && 
                    $pengurusIndex >= 0 && 
                    (!empty(trim((string)$row[4])) || !empty(trim((string)$row[8])))
                ) {
                    // Cek apakah ini sekretaris (jika pengurus berjumlah 1)
                    if (count($dataOrmas[$pengurusIndex]['pengurus']) == 1) {
                        $namaSekretaris = $this->extractSekretarisName($row[4] ?? '');
                        $teleponSekretaris = !empty(trim((string)$row[8])) ? 
                            trim((string)$row[8]) : 
                            $this->extractSekretarisPhone($dataOrmas[$pengurusIndex]['pengurus'][0]['telepon'] ?? '');
                        
                        if ($namaSekretaris || !empty($teleponSekretaris)) {
                            $dataOrmas[$pengurusIndex]['pengurus'][] = [
                                'jabatan' => 'sekretaris',
                                'nama' => $namaSekretaris,
                                'telepon' => $teleponSekretaris
                            ];
                        }
                    }
                    // Cek apakah ini bendahara (jika pengurus berjumlah 2)
                    elseif (count($dataOrmas[$pengurusIndex]['pengurus']) == 2) {
                        $namaBendahara = $this->extractBendaharaName($row[4] ?? '');
                        $teleponBendahara = !empty(trim((string)$row[8])) ? 
                            trim((string)$row[8]) : 
                            $this->extractBendaharaPhone($dataOrmas[$pengurusIndex]['pengurus'][0]['telepon'] ?? '');
                        
                        if ($namaBendahara || !empty($teleponBendahara)) {
                            $dataOrmas[$pengurusIndex]['pengurus'][] = [
                                'jabatan' => 'bendahara',
                                'nama' => $namaBendahara,
                                'telepon' => $teleponBendahara
                            ];
                        }
                    }
                }
            }
        }
        // Simpan data untuk debugging
        $this->data = $dataOrmas;
        
        // if ($this->debug) {
        //     dd([
        //         'message' => 'Data Ormas Debug',
        //         'data' => $dataOrmas,
        //         'count' => count($dataOrmas)
        //     ]);
        // }
        
        // Kode di bawah tidak akan dieksekusi karena dd() menghentikan eksekusi
        return $dataOrmas;
    }

    // Method untuk mendapatkan data yang telah diproses (untuk debugging)
    public function getCollectedData()
    {
        return $this->data;
    }

    // ===============================================================================================================================

    // Fungsi untuk mengekstrak nama ketua dari kolom pengurus
    protected function extractKetuaName(string $input): ?string
    {
        // Jika format seperti "K : [nama], S : [nama], B : [nama]"
        if (preg_match('/K :\s*(.*?)(,|$)/i', $input, $matches)) {
            return trim($matches[1]);
        }
        
        // Jika format lain atau tidak ada prefix, kembalikan seluruh string
        // karena biasanya pada baris pertama hanya berisi nama ketua
        return !empty(trim($input)) ? trim($input) : null;
    }

    // Fungsi untuk mengekstrak nama sekretaris dari kolom pengurus
    protected function extractSekretarisName(string $input): ?string
    {
        // Jika format seperti "S : [nama]" atau hanya nama saja
        if (preg_match('/S :\s*(.*?)$/i', $input, $matches)) {
            return trim($matches[1]);
        }
        
        return !empty(trim($input)) ? trim($input) : null;
    }

    // Fungsi untuk mengekstrak nama bendahara dari kolom pengurus
    protected function extractBendaharaName(string $input): ?string
    {
        // Jika format seperti "B : [nama]" atau hanya nama saja
        if (preg_match('/B :\s*(.*?)$/i', $input, $matches)) {
            return trim($matches[1]);
        }
        
        return !empty(trim($input)) ? trim($input) : null;
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
    

    // Membuat fungsi untuk mengonversi tanggal Excel ke format yang lebih baik
    private function formatExcelDate($value) 
    {
        // Cek apakah nilai adalah numeric (kemungkinan tanggal Excel)
        if (is_numeric($value)) {
            try {
                // Konversi dari serial number Excel ke format tanggal PHP
                // Excel serial date dimulai dari 1 Januari 1900
                $dateValue = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
                return $dateValue->format('d/m/Y');
            } catch (\Exception $e) {
                // Jika gagal konversi, kembalikan nilai asli
                return $value;
            }
        } else {
            // Ini untuk menangani jika tanggal sudah dalam format string
            return $value;
        }
    }
}

