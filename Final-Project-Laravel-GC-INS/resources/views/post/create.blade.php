@extends('layout.master')
@section('content')
    <!-- Form untuk membuat postingan -->
<div class="container">
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Pilihan Topik -->
        <div class="mb-3">
            <label for="id_topik" class="form-label">Topik</label>
            <select class="form-control" name="id_topik" id="id_topik" required>
                <option value="" disabled selected>Pilih Topik</option>
                @foreach($topics as $topic)
                    <option value="{{ $topic->id }}">{{ $topic->topik }}</option>
                @endforeach
            </select>
        </div>

        <!-- Judul Postingan -->
        <div class="mb-3">
            <label for="title" class="form-label">Judul Postingan</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul postingan" required>
        </div>

        <!-- Isi Postingan -->
        <div class="mb-3">
            <label for="content" class="form-label">Isi Postingan</label>
            <textarea class="form-control" id="content" name="content" rows="5" placeholder="Tulis isi postingan di sini" required></textarea>
        </div>

        <!-- Upload Gambar -->
        <div class="mb-3">
            <label for="image" class="form-label">Upload Gambar</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <!-- ID User (Hidden) -->
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        <!-- Tombol Post -->
        <button type="submit" class="btn btn-primary">Post</button>
    </form>
</div>

@endsection