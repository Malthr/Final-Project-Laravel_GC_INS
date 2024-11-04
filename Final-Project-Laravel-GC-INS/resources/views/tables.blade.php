@extends('layout.master')
@section('content')

<!-- Card Postingan -->
<div class="d-flex justify-content-start my-3">
    <Form action="{{ Route('post.create') }}">
        <button class="btn btn-primary">Add Post</button>
    </Form>
</div>
@foreach ($posts as $post)
    <div class="col-md-9 mx-auto card border-secondary mb-3">
        <div class="card">
            <div class="card-header pb-1">
                <div class="row">
                    <h1 class="card-title fs-4 mb-1">{{ $post->title }}</h1>
                </div>
                <div class="row">
                    <small class="d-block text-muted" style="font-size:small">{{ $post->topik->topik ?? 'Topik Tidak Ditemukan' }}</small>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $post->post_text }}</p>

                @if ($post->gambar)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $post->gambar) }}" alt="Post Image" class="img-fluid">
                    </div>
                @endif

                <!-- Form untuk Komentar -->
                <div class="mt-3">
                    <a href="#" class="text-secondary" data-bs-toggle="collapse" data-bs-target="#commentForm{{ $post->id }}" aria-expanded="false" aria-controls="commentForm{{ $post->id }}">
                        <i class="fas fa-comment-dots"></i> Komentar
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
                            <button type="submit" class="btn btn-primary">Kirim Komentar</button>
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