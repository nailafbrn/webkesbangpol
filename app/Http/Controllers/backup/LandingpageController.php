<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidang;
use App\Models\Post;
use Illuminate\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

use Illuminate\Http\JsonResponse;


class LandingpageController extends Controller
{
    //
    public function index(): View
    {
        $posts = Post::with('bidang')->orderBy('created_at', 'desc')->get();
        $bidangs = Bidang::all(); // Kalau masih dipakai
    
        return view('landingpage.beranda', compact('posts', 'bidangs'));
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
    
        if ($request->filled('bidang_id')) {
            $query->where('bidang_id', $request->bidang_id);
        }
    
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
    
        // Sama seperti filterArtikel()
        if ($request->sort === 'created_desc') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort === 'created_asc') {
            $query->orderBy('created_at', 'asc');
        } elseif ($request->sort === 'title_asc') {
            $query->orderBy('title', 'asc');
        } elseif ($request->sort === 'title_desc') {
            $query->orderBy('title', 'desc');
        }
    
        $posts = $query->paginate(9)->withQueryString();
        $bidangs = Bidang::all();
    
        return view('landingpage.artikel.semua-artikel', compact('posts', 'bidangs'));
    }




    public function filterArtikel(Request $request)
    {
        $query = Post::with('bidang');

        if ($request->filled('bidang_id')) {
            $query->where('bidang_id', $request->bidang_id);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Gabungan sort
        switch ($request->sort) {
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
