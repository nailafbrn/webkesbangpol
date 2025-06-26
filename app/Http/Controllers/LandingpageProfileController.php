<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\VisiMisi;
use App\Models\Strukturor;
use App\Models\Program;
use App\Models\Bidang;
use App\Models\LandasanHukum;

use Laravel\Ui\Presets\Vue;

class LandingpageProfileController extends Controller
{
    public function tampilVisiMisi(): View
    {
        $visimisis = VisiMisi::all();
        return view('landingpage.profile.visimisi', compact('visimisis'));
    }

    public function tampilTugasFungsi(): View
    {
        $visimisis = VisiMisi::first();

        return view('landingpage.profile.tugasfungsi', compact('visimisis'));
    }

    public function tampilStruktur(): View
    {
        $strukturors = Strukturor::all();
        return view('landingpage.profile.strukturorganisasi', compact('strukturors'));
    }

    public function tampilDasarHukum(): View
    {
        $groupedHukums = LandasanHukum::with('bidang')->get()->groupBy(function ($hukum) {
            return $hukum->bidang->nama_bidang ?? 'Tanpa Bidang';
        });
    
        return view('landingpage.profile.dasarhukum', compact('groupedHukums'));
    }

    public function tampilProgram(): View
    {
        $groupedPrograms = Program::with('bidang')->get()->groupBy(function ($program) {
            return $program->bidang->nama_bidang ?? 'Tanpa Bidang';
        });
    
        return view('landingpage.profile.program', compact('groupedPrograms'));
    }
    

    public function tampilSejarah(): View
    {
        $visimisis = VisiMisi::all();
        return view('landingpage.profile.sejarah', compact('visimisis'));
    }

    public function tampilMenuProfile(): View
    {
        return view('landingpage.profile.menu');
    }
}
