<?php

namespace App\Imports;


use Illuminate\Support\Str;
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
        $foundBadanTitle = false;
        $currentOrganisasi = null;
        $pengurusIndex = -1; // Index untuk melacak organisasi saat ini

        foreach ($rows as $row) {
            $firstCell = trim((string) $row[0]);

            // Lewati baris kosong
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
                
                // Cek apakah ada pola "DAFTAR ORGANISASI" di baris tersebut
                if (preg_match('/DAFTAR\s+ORGANISASI/i', $rowContent)) {
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

