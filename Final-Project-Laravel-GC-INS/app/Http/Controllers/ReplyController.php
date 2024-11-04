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
        // Validasi input
        $request->validate([
            'id_post' => 'required|exists:posts,id',
            'reply' => 'required|string|max:1000',
            'gambar' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov|max:2048', // Maksimal 2MB
        ]);

        // Membuat instansi Reply baru
        $reply = new Reply();
        $reply->id_user = Auth::id(); // Ambil ID pengguna yang sedang login
        $reply->id_post = $request->id_post;
        $reply->id_parent = $request->id_parent; // Jika Anda ingin mengimplementasikan balasan
        $reply->reply = $request->reply;

        // Menyimpan gambar jika diunggah
        if ($request->hasFile('gambar')) {
            // Simpan gambar ke storage
            $path = $request->file('gambar')->store('uploads/reply_images', 'public');
            $reply->gambar = $path; // Simpan path gambar ke database
        }

        // Simpan komentar ke database
        $reply->save();

        // Redirect ke halaman yang diinginkan, misalnya ke halaman postingan
        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}

