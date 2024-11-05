@extends('layout.master')
@section('content')
<!-- Form untuk membuat postingan -->
<div class="col-md-9 mx-auto">
    <div class="container">
    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Pilihan Topik -->
        <h1 class="mb-3 fs-3 fw-bold">Create Post</h1>
        <div class="col-md-3 mb-3">
            <select name="id_topik" id="id_topik" required>
                <option value="" disabled selected>Topik</option>
                @foreach($topics as $topic)
                <option value="{{ $topic->id }}">{{ $topic->topik }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Judul Postingan -->
        <div class="mb-3">
            <input type="text" class="form-control rounded-4 py-2" id="title" name="title" placeholder="Title *" required>
        </div>        

        <!-- Isi Postingan -->
        <div class="mb-3">
            <textarea class="form-control rounded-4" id="content" name="content" rows="5" placeholder="Body" required></textarea>
        </div>

        <!-- Upload Gambar -->
        <div class="">
            <small class="d-block text-muted" style="font-size:small">Optional</small>
        </div>
        
        <div class="input-group flex-nowrap mb-3">
            <input type="file" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
        </div>
        

        <!-- ID User (Hidden) -->
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        <!-- Tombol Post -->
        <button type="submit" class="btn btn-primary rounded-pill px-3">Post</button>
    </form>
</div>
</div>

@endsection
@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.bootstrap5.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>

<script>
    $(document).ready(function() {
        $('#id_topik').selectize({
            create: true,  // Enables text input
            sortField: 'text'
        });
    });
</script>

@endpush