<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topik;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        // Mengambil semua postingan beserta komentar yang berhubungan
        $user = Auth::user();
        $posts = Post::with(['topik', 'replys.user'])->get();

        return view('homepage', compact('posts','user'));
    }

    public function create()
    {
        $topics = Topik::all();
        $user = Auth::user();
        return view('post.create',compact('topics','user'));
    }

    public function store(Request $request)
    {
            // Validasi input
    $request->validate([
        'id_topik' => 'required|exists:topiks,id',
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Max 2MB
        'user_id' => 'required|exists:users,id',
    ]);

    // Upload gambar jika ada
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
    }

    // Simpan postingan
    Post::create([
        'id_topik' => $request->id_topik,
        'title' => $request->title,
        'post_text' => $request->content,
        'gambar' => $imagePath,
        'id_user' => $request->user_id,
    ]);

    return redirect()->route('table')->with('success', 'Postingan berhasil dibuat!');
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}