<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Log;

class OrmasImport implements ToCollection
{
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

        foreach ($rows as $row) {
            $firstCell = trim((string) $row[0]);

            // Lewati baris kosong
            if ($row->filter()->isEmpty()) continue;

            // Deteksi awal baris judul fleksibel
            if (!$foundJudul && preg_match('/DAFTAR\s+ORGANISASI/i', $firstCell)) {
                dump('Judul Ditemukan:', $firstCell);
                $foundJudul = true;
                continue;
            }

            // Deteksi baris "BULAN: ..."
            if ($foundJudul && stripos($firstCell, 'BULAN:') !== false) {
                preg_match('/BULAN:\s*([A-Z]+)\s+(\d{4})/i', $firstCell, $match);
                if ($match) {
                    $currentBulan = ucfirst(strtolower($match[1]));
                    $currentTahun = $match[2];
                    $currentHeaders = []; // Reset header karena kemungkinan struktur tabel berubah
                }
                continue;
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
                $dataOrmas[] = [
                    'bulan' => $currentBulan,
                    'tahun' => $currentTahun,
                    'no' => isset($row[0]) ? trim((string)$row[0]) : null,
                    'tanggal' => isset($row[1]) ? trim((string)$row[1]) : null,
                    'nama_organisasi' => isset($row[2]) ? trim((string)$row[2]) : null,
                    'alamat' => isset($row[3]) ? trim((string)$row[3]) : null,
                    'nama_pengurus' => $this->parsePengurus($row[4] ?? ''),
                    'akta' => isset($row[5]) ? trim((string)$row[5]) : null,
                    'ahu_skt' => isset($row[6]) ? trim((string)$row[6]) : null,
                    'bidang' => isset($row[7]) ? trim((string)$row[7]) : null,
                    'telepon_pengurus' => $this->parseTelepon($row[8] ?? ''),
                    'npwp' => isset($row[9]) ? trim((string)$row[9]) : null,
                ];
            }
        }

            // Tampilkan hasil parsing
            // dd([
            // 'total_rows' => $rows->count(),
            // 'data_ormas_count' => count($dataOrmas),
            // 'first_ormas' => array_slice($dataOrmas, 0, 3),
            // ]);
        dd($dataOrmas); // Tampilkan hasil parsing

    }

    protected function parsePengurus(string $input): array
    {
        $result = [
            'ketua' => null,
            'sekretaris' => null,
            'bendahara' => null
        ];
        preg_match('/K :\s*(.*?)(,|$)/i', $input, $k);
        preg_match('/S :\s*(.*?)(,|$)/i', $input, $s);
        preg_match('/B :\s*(.*?)(,|$)/i', $input, $b);
        if ($k) $result['ketua'] = trim($k[1]);
        if ($s) $result['sekretaris'] = trim($s[1]);
        if ($b) $result['bendahara'] = trim($b[1]);
        return $result;
    }

    protected function parseTelepon(string $input): array
    {
        $result = [
            'ketua' => null,
            'sekretaris' => null,
            'bendahara' => null
        ];
        
        // Membersihkan input dari whitespace di awal dan akhir
        $input = trim($input);
        
        // Memisahkan input berdasarkan baris baru
        $lines = preg_split('/\r\n|\r|\n/', $input);
        
        // Mengambil nomor telepon dari setiap baris
        if (!empty($lines[0])) {
            $result['ketua'] = trim($lines[0]);
        }
        
        if (isset($lines[1]) && !empty($lines[1])) {
            $result['sekretaris'] = trim($lines[1]);
        }
        
        if (isset($lines[2]) && !empty($lines[2])) {
            $result['bendahara'] = trim($lines[2]);
        }
        
        return $result;
    }
}
