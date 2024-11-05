<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topik;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil semua postingan beserta komentar yang berhubungan
        $user = Auth::user();
        $topics = Topik::withCount('postingan')->get();
    
        // Ambil id_topik dari query string jika ada
        $id_topik = $request->query('id_topik');
    
        // Ambil postingan dengan filter berdasarkan id_topik jika ada
        if ($id_topik) {
            $posts = Post::with(['topik', 'replys.user'])
                         ->where('id_topik', $id_topik)
                         ->get();
        } else {
            // Jika tidak ada filter, ambil semua postingan
            $posts = Post::with(['topik', 'replys.user'])->get();
        }
    
        return view('homepage', compact('posts', 'user', 'topics'));
    }    

    public function create()
    {
        $topics = Topik::all();
        $user = Auth::user();
        return view('post.create',compact('topics','user'));
    }

    public function store(Request $request)
    {
        // Validasi input, dengan menyesuaikan `id_topik` agar bisa berupa teks atau ID numerik
        $request->validate([
            'id_topik' => 'required|string', // String untuk menerima ID atau nama topik baru
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Max 2MB
            'user_id' => 'required|exists:users,id',
        ]);
    
        // Menangani topik baru jika input `id_topik` adalah teks (bukan angka)
        $topikId = $request->id_topik;
        if (!is_numeric($topikId)) {
            // Simpan topik baru
            $newTopik = Topik::create(['topik' => $topikId]);
            $topikId = $newTopik->id; // Ambil ID topik yang baru dibuat
        }
    
        // Upload gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }
    
        // Simpan postingan dengan ID topik (baik topik baru atau yang sudah ada)
        Post::create([
            'id_topik' => $topikId,
            'title' => $request->title,
            'post_text' => $request->content,
            'gambar' => $imagePath,
            'id_user' => $request->user_id,
        ]);
    
        return redirect()->route('homepage')->with('success', 'Postingan berhasil dibuat!');
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $query = $request->input('query'); // Mengambil input dari form pencarian
        
        // Filter topik dengan jumlah postingan
        $topics = Topik::withCount('postingan')->get();
        
        // Memulai query untuk postingan dengan relasi `topik` dan `replys.user`
        $postsQuery = Post::with(['topik', 'replys.user']);
        
        // Jika ada `id_topik` dalam request, filter postingan berdasarkan `id_topik`
        $id_topik = $request->query('id_topik');
        if ($id_topik) {
            $postsQuery->where('id_topik', $id_topik);
        }
        
        // Melakukan pencarian berdasarkan kolom `topik` atau `username`
        if ($query) {
            $postsQuery->whereHas('topik', function ($q) use ($query) {
                $q->where('topik', 'like', '%' . $query . '%');
            })->orWhereHas('user', function ($q) use ($query) {
                $q->where('username', 'like', '%' . $query . '%');
            });
        }
    
        // Jika permintaan berasal dari AJAX, kembalikan data pencarian dalam format JSON
        if ($request->ajax()) {
            // Pencarian `users` dan `topics` sesuai dengan query
            $users = User::where('username', 'like', '%' . $query . '%')->get();
            $topics = Topik::where('topik', 'like', '%' . $query . '%')->get();
            
            // Mengembalikan hasil dalam bentuk JSON
            return response()->json([
                'users' => $users,
                'topics' => $topics,
                'posts' => $postsQuery->get() // Mengirim postingan yang difilter
            ]);
        }
        
        // Jika bukan permintaan AJAX, ambil semua posting yang difilter dan tampilkan di homepage
        $posts = $postsQuery->get();
        
        return view('homepage', compact('posts', 'user', 'topics'));
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