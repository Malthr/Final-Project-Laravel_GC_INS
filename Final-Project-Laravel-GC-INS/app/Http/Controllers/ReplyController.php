<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReplyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reply' => 'nullable|string',
            'id_post' => 'required|exists:posts,id',
            'id_reply' => 'nullable|exists:replys,id', // Memastikan ID reply valid
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,video/mp4,video/x-m4v,video/*',
        ]);
    
        // Logika untuk menyimpan balasan
        $reply = new Reply();
        $reply->id_user = Auth::id(); // Ambil ID pengguna yang sedang login
        $reply->reply = $request->reply;
        $reply->id_post = $request->id_post; // Mengaitkan balasan dengan post
        $reply->id_parent = $request->id_reply; // Mengaitkan balasan dengan komentar yang dibalas
        // Simpan gambar jika ada
        if ($request->hasFile('gambar')) {
            $reply->gambar = $request->file('gambar')->store('replies', 'public'); // Sesuaikan path penyimpanan sesuai kebutuhan
        }
        $reply->save();
    
        return redirect()->back()->with('status', 'Reply posted successfully.');
    }
    
}

