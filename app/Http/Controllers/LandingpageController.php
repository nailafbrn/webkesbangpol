<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Bidang;
use App\Models\Post;
use App\Models\Galeri;
use App\Models\Mitra;
use Illuminate\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class LandingpageController extends Controller
{
    //
    // FUNGSI-FUNGSI LAMA ANDA (TETAP ADA DAN AMAN)
    //
    public function index(): View
    {
        $banners = Banner::orderBy('created_at', 'desc')->get();
        $galeris = Galeri::with('program')->orderBy('created_at', 'desc')->get();
        $posts = Post::with('bidang')->orderBy('created_at', 'desc')->get();
        $bidangs = Bidang::all();
    
        return view('landingpage.beranda', compact('posts', 'bidangs', 'galeris', 'banners'));
    }

    public function isiArtikel($slug): View
    {
        $post = Post::with('bidang')->where('slug', $slug)->firstOrFail();
        $bidangs = Bidang::all();
        $latestPosts = Post::with('bidang')
            ->orderBy('created_at', 'desc')
            ->where('slug', '!=', $slug)
            ->take(5)
            ->get();

        return view('landingpage.artikel.isi-artikel', compact('post', 'bidangs', 'latestPosts'));
    }

    public function semuaArtikel(Request $request)
    {
        $validated = $request->validate([
            'bidang_id' => 'nullable|exists:bidangs,id',
            'search' => 'nullable|string|max:100',
            'sort' => 'nullable|in:created_desc,created_asc,title_asc,title_desc',
        ]);

        $query = Post::with('bidang');
    
        if (!empty($validated['bidang_id'])) {
            $query->where('bidang_id', $validated['bidang_id']);
        }

        if (!empty($validated['search'])) {
            $query->where('title', 'like', '%' . $validated['search'] . '%');
        }

        switch ($validated['sort'] ?? null) {
            case 'created_desc': $query->orderBy('created_at', 'desc'); break;
            case 'created_asc': $query->orderBy('created_at', 'asc'); break;
            case 'title_asc': $query->orderBy('title', 'asc'); break;
            case 'title_desc': $query->orderBy('title', 'desc'); break;
        }
        
        $programId = $request->input('program_id');

        if ($programId) {
            $query->where('program_id', $programId);
        }
    
        $posts = $query->paginate(9)->withQueryString();
        $bidangs = Bidang::all();
    
        return view('landingpage.artikel.semua-artikel', compact('posts', 'bidangs'));
    }

    public function filterArtikel(Request $request)
    {
        $validated = $request->validate([
            'bidang_id' => 'nullable|exists:bidangs,id',
            'search' => 'nullable|string|max:100',
            'sort' => 'nullable|in:created_desc,created_asc,title_asc,title_desc',
        ]);
        
        $query = Post::with('bidang');

        if (!empty($validated['bidang_id'])) {
            $query->where('bidang_id', $validated['bidang_id']);
        }

        if (!empty($validated['search'])) {
            $query->where('title', 'like', '%' . $validated['search'] . '%');
        }

        switch ($validated['sort'] ?? null) {
            case 'created_desc': $query->orderBy('created_at', 'desc'); break;
            case 'created_asc': $query->orderBy('created_at', 'asc'); break;
            case 'title_asc': $query->orderBy('title', 'asc'); break;
            case 'title_desc': $query->orderBy('title', 'desc'); break;
        }

        $posts = $query->paginate(9)->withQueryString();
        $html = view('landingpage.artikel.artikel-list', compact('posts'))->render();
        return response()->json(['html' => $html]);
    }
    
    // ==========================================================
    // == FUNGSI-FUNGSI UNTUK MITRA ==
    // ==========================================================

    public function tampilMitra(): View
    {
        $mitraKerjaSama = Mitra::where(DB::raw("TRIM(kategori_mitra)"), '!=', 'PARPOL')->latest()->get();
        $partaiPolitik = Mitra::where(DB::raw("TRIM(kategori_mitra)"), '=', 'PARPOL')->latest()->get();
        return view('landingpage.mitra.index', compact('mitraKerjaSama', 'partaiPolitik'));
    }

    public function detailMitra(string $kategori): View
    {
        // ==========================================================
        // == PERBAIKANNYA ADA DI SINI: PETA TERJEMAHAN LENGKAP ==
        // ==========================================================
        $dbKategori = match (strtolower($kategori)) {
            'forkopimda'     => 'FORKOPIMDA',
            'kpu'            => 'KPU',
            'bawaslu'        => 'BAWASLU',
            'bnn'            => 'BNN',
            'partai-politik' => 'PARPOL',
            'fkdm'           => 'FKDM',
            'fkub'           => 'FKUB',
            'fpk'            => 'FPK',
            default          => strtoupper($kategori),
        };

        $mitras = Mitra::where(DB::raw("TRIM(UPPER(kategori_mitra))"), '=', $dbKategori)->get();

        if ($mitras->isEmpty()) {
            abort(404);
        }

        if ($mitras->count() == 1) {
            $mitra = $mitras->first();
            return view('landingpage.mitra.detail', compact('mitra', 'kategori'));
        }

        return view('landingpage.mitra.kategori', [
            'mitras' => $mitras,
            'namaKategori' => $kategori
        ]);
    }

    public function showMitraDetail(Mitra $mitra): View
    {
        $kategori = $mitra->kategori_mitra;
        return view('landingpage.mitra.detail', compact('mitra', 'kategori'));
    }
}
