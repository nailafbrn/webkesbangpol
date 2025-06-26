<?php

namespace App\Http\Controllers;
use setasign\Fpdi\Fpdi;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Renja;
use App\Models\Renstra;
use App\Models\Iku;
use App\Models\UkurKerja;
use App\Models\LaporanAkip;

use App\Models\LandasanHukum;

use Laravel\Ui\Presets\Vue;
class LandingpageSakipController extends Controller
{
    public function tampilRenja(): View
    {
        $renjas = Renja::paginate(10);
        return view('landingpage.sakip.renja', compact('renjas'));
    }

    
    public function tampilRenstra(): View
    {
        // $renstra = Renstra::all();
        $renstras = Renstra::paginate(10);
        return view('landingpage.sakip.renstra', compact('renstras'));
    }

    public function tampilIku(): View
    {
        $ikus = Iku::paginate(10);
        return view('landingpage.sakip.iku', compact('ikus'));
    }

    public function tampilUkurkerja(): View
    {
        $ukurkerjas = UkurKerja::paginate(10);
        return view('landingpage.sakip.ukurkerja', compact('ukurkerjas'));
    }

    public function tampillAkip(): View
    {
        $lakips =LaporanAkip::paginate(10);
        return view('landingpage.sakip.lakip', compact('lakips'));
    }

    public function tampilMenuSakip(): View
    {
        return view('landingpage.sakip.menu');
    }
}
