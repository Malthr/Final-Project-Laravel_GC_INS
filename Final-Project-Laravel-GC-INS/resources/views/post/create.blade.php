@extends('layout.master')
@section('content')
<!-- Form untuk membuat postingan -->
<div class="container">
    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Pilihan Topik -->
        <div class="mb-3">
            <label for="id_topik" class="form-label">Topik</label>
            <select class="form-control" name="id_topik" id="id_topik" required>
                <option value="" disabled selected>Pilih atau Tambah Topik</option>
                @foreach($topics as $topic)
                <option value="{{ $topic->id }}">{{ $topic->topik }}</option>
                @endforeach
            </select>
        </div>

        <!-- Judul Postingan -->
        <div class="mb-3">
            <label for="title" class="form-label">Judul Postingan</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul postingan"
                required>
        </div>

        <!-- Isi Postingan -->
        <div class="mb-3">
            <label for="content" class="form-label">Isi Postingan</label>
            <textarea class="form-control" id="content" name="content" rows="5"
                placeholder="Tulis isi postingan di sini" required></textarea>
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
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
<script>
    $(document).ready(function() {
        console.log("Inisialisasi Selectize dimulai."); // Log untuk memastikan ini dieksekusi
        $('#id_topik').selectize({
            create: true, // Mengaktifkan kemampuan untuk menambah item baru
            sortField: 'text'
        });
    });
</script>
@endpush