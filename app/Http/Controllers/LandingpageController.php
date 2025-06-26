<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Bidang;
use App\Models\Post;
use App\Models\Galeri;
use Illuminate\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

use Illuminate\Http\JsonResponse;


class LandingpageController extends Controller
{
    //
    public function index(): View
    {
        $banners = Banner::orderBy('created_at', 'desc')->get();
        $galeris = Galeri::with('program')->orderBy('created_at', 'desc')->get();
        $posts = Post::with('bidang')->orderBy('created_at', 'desc')->get();
        $bidangs = Bidang::all(); // Kalau masih dipakai
    
        return view('landingpage.beranda', compact('posts', 'bidangs', 'galeris', 'banners'));
    }

    public function isiArtikel($slug): View
    {
        $post = Post::with('bidang')->where('slug', $slug)->firstOrFail();
        $bidangs = Bidang::all();
        $latestPosts = Post::with('bidang')
            ->orderBy('created_at', 'desc')
            ->where('slug', '!=', $slug) // Kecuali artikel yang sedang dibuka
            ->take(5)
            ->get();

        return view('landingpage.artikel.isi-artikel', compact('post', 'bidangs', 'latestPosts'));
    }



    public function semuaArtikel(Request $request)
    {

        // ✅ Validasi input agar tidak sembarangan
        $validated = $request->validate([
            'bidang_id' => 'nullable|exists:bidangs,id',
            'search' => 'nullable|string|max:100',
            'sort' => 'nullable|in:created_desc,created_asc,title_asc,title_desc',
        ]);

        $query = Post::with('bidang');
    
        // ✅ Gunakan input tervalidasi
        if (!empty($validated['bidang_id'])) {
            $query->where('bidang_id', $validated['bidang_id']);
        }

        if (!empty($validated['search'])) {
            $query->where('title', 'like', '%' . $validated['search'] . '%');
        }

        // ✅ Gunakan switch sort yang tervalidasi
        switch ($validated['sort'] ?? null) {
            case 'created_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
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
            case 'created_desc':
                $query->orderBy('created_at', 'desc');
                break;
            case 'created_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
        }

        $posts = $query->paginate(9)->withQueryString();

        // Mengembalikan HTML artikel yang sudah difilter
        $html = view('landingpage.artikel.artikel-list', compact('posts'))->render();

        return response()->json(['html' => $html]); // Kirim kembali HTML yang baru
    }
    
    
    
}
