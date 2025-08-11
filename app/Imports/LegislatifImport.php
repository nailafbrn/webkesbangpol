<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;

class LegislatifImport implements WithMultipleSheets, SkipsUnknownSheets
{
    /**
     * @var LegislatifSheetImport
     */
    protected $sheetImport;

    public function __construct()
    {
        // Kita hanya mengimpor sheet pertama (indeks 0)
        $this->sheetImport = new LegislatifSheetImport();
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            0 => $this->sheetImport, // Menggunakan instance yang sudah dibuat
        ];
    }

    /**
     * Mengabaikan sheet lain jika ada.
     */
    public function onUnknownSheet($sheetName)
    {
        // Do nothing.
    }

    /**
     * Method untuk mendapatkan instance import sheet spesifik
     * agar kita bisa mengambil data failures dan success count di controller.
     *
     * @return LegislatifSheetImport
     */
    public function getSheetImport(): LegislatifSheetImport
    {
        return $this->sheetImport;
    }
}