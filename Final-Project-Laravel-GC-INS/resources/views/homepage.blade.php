@extends('layout.master')
@section('content')

<!-- Card Postingan -->
<div id="posts-container">
@foreach ($posts as $post)
    <div class="col-md-9 mx-auto card border-secondary border-opacity-10 mb-3 shadow-none">
        <div class="card">
            <div class="card-header pb-1">
                <div class="row">
                    <h1 class="card-title fs-4 mb-1">{{ $post->title }}</h1>
                </div>
                <div class="row">
                    <small class="d-block text-muted" style="font-size:small">
                        {{ $post->topik->topik ?? 'Topik Tidak Ditemukan' }}
                    </small>
                    <small class="d-block text-muted" style="font-size:small">
                        Diunggah oleh {{ $post->user->username ?? 'Pengguna Tidak Ditemukan' }} pada {{ $post->created_at->format('d M Y, H:i') }}
                    </small>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text white-space">{!! nl2br(e($post->post_text)) !!}</p>

                @if ($post->gambar)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $post->gambar) }}" alt="Post Image" class="img-fluid">
                    </div>
                @endif

                <!-- Form untuk Komentar -->
                <div class="mt-3">
                    <a href="#" class="text-secondary" data-bs-toggle="collapse" data-bs-target="#commentForm{{ $post->id }}" aria-expanded="false" aria-controls="commentForm{{ $post->id }}">
                        <button class="btn btn-outline-dark rounded-pill">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16" fill="currentColor">
                                <path d="M1 2.75C1 1.784 1.784 1 2.75 1h10.5c.966 0 1.75.784 1.75 1.75v7.5A1.75 1.75 0 0 1 13.25 12H9.06l-2.573 2.573A1.458 1.458 0 0 1 4 13.543V12H2.75A1.75 1.75 0 0 1 1 10.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h2a.75.75 0 0 1 .75.75v2.19l2.72-2.72a.749.749 0 0 1 .53-.22h4.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z"></path>
                            </svg>
                            Comment
                        </button>
                    </a>
                    <div class="collapse mt-2" id="commentForm{{ $post->id }}">
                        <form action="{{ Route('replys.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_post" value="{{ $post->id }}">
                            <div class="mb-3">
                                <textarea name="reply" class="form-control" rows="3" placeholder="Tulis komentar Anda..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="replyImage{{ $post->id }}" class="form-label">Unggah Gambar atau Video</label>
                                <input type="file" name="gambar" class="form-control" id="replyImage{{ $post->id }}" accept="image/*,video/*">
                            </div>
                            <button type="submit" class="btn btn-dark rounded-pill px-3 mb-3">Send</button>
                        </form>
                        @foreach ($post->replys as $reply)
                        <div class="border p-2 mb-2">
                            <p><strong>{{ $reply->user->username }}</strong> berkata:</p>
                            <p>{{ $reply->reply }}</p>
                            @if ($reply->gambar)
                                <div>
                                    @if (strpos($reply->gambar, '.mp4') !== false || strpos($reply->gambar, '.mov') !== false)
                                        <video controls class="img-fluid">
                                            <source src="{{ asset('storage/' . $reply->gambar) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img src="{{ asset('storage/' . $reply->gambar) }}" alt="Reply Image" class="img-fluid">
                                    @endif
                                </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>



@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Memastikan jQuery dimuat -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#example1').DataTable(); // Menginisialisasi DataTable
});
</script>
@endpush

@push('tableStyle')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@endpush