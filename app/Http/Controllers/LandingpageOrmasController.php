<?php

namespace App\Http\Controllers;

use App\Models\Ormas;
use App\Models\PengurusOrmas;
use App\Models\DokumenOrmas;
use Illuminate\View\View;
use Illuminate\Http\Request;

class LandingpageOrmasController extends Controller
{
    public function tampilDataOrmas(Request $request): View
    {
        $query = Ormas::with(['pengurus', 'dokumen']);
        
        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('nama_organisasi', 'LIKE', '%' . $searchTerm . '%');
        }
        
        $ormass = $query->orderBy('nama_organisasi')
                        ->paginate(9);
                        
        return view('landingpage.informasi.data-ormas', compact('ormass'));
    }
}
