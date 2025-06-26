<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use App\Models\Ormas;
use App\Models\PengurusOrmas;
use App\Models\DokumenOrmas;

class MultiSheetOrmasImport implements WithMultipleSheets, SkipsUnknownSheets
{
    use WithConditionalSheets;
    
    protected $debug = false;
    protected $combinedData = [];
    
    // Mapping sheet names to processor classes
    protected $sheetProcessors = [
        'DATA VERIF ORMAS' => OrmasImport::class,
        'OrmasLSM' => OrmasLsmImport::class,
        'Yayasan' => YayasanImport::class,
    ];
    
    protected $processorInstances = [];
    
    public function __construct($debug = false)
    {
        $this->debug = $debug;
        
        // Inisialisasi kelas-kelas processor dengan mode debug
        foreach ($this->sheetProcessors as $sheetName => $processorClass) {
            $this->processorInstances[$sheetName] = new $processorClass($debug);
        }
    }
    
    public function sheets(): array
    {
        return $this->processorInstances;
    }

    
    public function onUnknownSheet($sheetName)
    {
        // Log unknown sheets atau handle sesuai kebutuhan
        info("Skipping unknown sheet: {$sheetName}");
    }
    
    // Method untuk kondisional load specific sheets jika diperlukan
    public function conditionalSheets(): array
    {
        return $this->sheetProcessors;
    }
    
    /**
     * Mengumpulkan data dari semua processor setelah import selesai
     * Dapat dipanggil setelah proses import Excel berhasil
     */
    public function collectAllData()
    {
        $this->combinedData = [];
        
        foreach ($this->processorInstances as $sheetName => $processor) {
            $sheetData = $processor->getCollectedData();
            $this->combinedData[$sheetName] = $sheetData;
        }
        return $this->combinedData;
    }
}