<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Bidang;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

class PostController extends Controller
{
    public function index(): View
    {
        $count = Post::count();
        $posts = Post::latest()->paginate(5);
        return view('dashboard.posts.index', compact('posts'));
    }

    public function create(): View
    {
        $programs = Program::all();
        $bidangs = Bidang::all();
        return view('dashboard.posts.create', compact('bidangs', 'programs'));
    }



    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'bidang_id' => 'required|exists:bidangs,id',
            'program_id' => 'required|exists:programs,id', 
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
            'title' => 'required|string|min:5|max:255',
            'content' => 'required|string|min:10',
        ]);

            // Membuat slug dari judul
        $slug = Str::slug($request->title);

        // Pastikan slug unik dengan memeriksa apakah sudah ada di database
        $originalSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $imageName = time() . '_' . $slug . '.' . $extension;
        $image->move(public_path('images/posts'), $imageName);

        Post::create([
            'bidang_id' => $request->bidang_id,
            'program_id' => $request->program_id,
            'image' => $imageName,
            'title' => $request->title,
            'content' => Purifier::clean($request->content),
            'slug' => $slug,
        ]);

        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View
    {
        $post = Post::findOrFail($id);
        return view('dashboard.posts.show', compact('post'));
    }

    public function edit(string $id): View
    {
        $post = Post::findOrFail($id);
        $programs = Program::all();
        $bidangs = Bidang::all(); // Ambil semua bidang
        return view('dashboard.posts.edit', compact('post', 'bidangs', 'programs'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'bidang_id' => 'required|exists:bidangs,id',
            'program_id' => 'required|exists:programs,id', 
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'title' => 'required|string|min:5|max:255',
            'content' => 'required|string|min:10',
        ]);


        $post = Post::findOrFail($id);

        // Membuat slug dari judul, hanya jika ada perubahan title
        $slug = Str::slug($request->title);

        // Pastikan slug unik
        $originalSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    
    
        if ($request->hasFile('image')) {
            // Upload file baru
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '_' . $slug . '.' . $extension;
            $image->move(public_path('images/posts'), $imageName);
    
            // Hapus gambar lama jika ada
            if (!empty($post->image)) {
                $oldImagePath = public_path('images/posts/' . $post->image);

                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $post->update([
                'bidang_id' => $request->bidang_id,
                'program_id' => $request->program_id,
                'image' => $imageName,
                'title' => $request->title,
                'content' => Purifier::clean($request->content),
                'slug' => $slug 
            ]);
        } else {
            // Jika tidak ada gambar baru
            $post->update([
                'bidang_id' => $request->bidang_id,
                'program_id' => $request->program_id,
                'title' => $request->title,
                'content' => Purifier::clean($request->content),
                'slug' => $slug // Menyimpan slug yang baru
            ]);
        }
    
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        $post = Post::findOrFail($id);
    
        // Hapus file gambar
        $imagePath = public_path('images/posts/' . $post->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    
        // Hapus data
        $post->delete();
    
        return redirect()->route('posts.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }


}