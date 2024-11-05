@extends('layout.master')
@section('content')

<!-- Card Postingan -->
<div id="posts-container">
    @foreach ($posts as $post)
    <div class="col-md-9 mx-auto card border-secondary border-opacity-10 mb-3 shadow-none">
        <div class="card">
            <div class="card-header pb-">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="card-title fs-4 mb-1">{{ $post->title }}</h1>
                    </div>
                    <div class="col-md-4 text-end">
                        <!-- Menampilkan Pengupload -->
                        <small class="text-muted" style="font-size:small">
                            {{ $post->user->username ?? 'Pengguna Tidak Ditemukan' }}
                        </small>
                        &#x2022; {{-- Dot Symbol --}}
                        <!-- Menampilkan Waktu -->
                        <small class="text-muted" style="font-size:small">
                            {{ $post->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
                <div class="row">
                    <small class="d-block text-muted" style="font-size:small">
                        {{ $post->topik->topik ?? 'Topik Tidak Ditemukan' }}
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

                <div class="mt-3">
                    {{-- Comment Button --}}
                    <a href="#" class="text-secondary" data-bs-toggle="collapse"
                        data-bs-target="#commentList{{ $post->id }}" aria-expanded="false"
                        aria-controls="commentForm{{ $post->id }}">
                        <button class="btn btn-outline-dark rounded-pill">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"
                                fill="currentColor">
                                <path
                                    d="M1 2.75C1 1.784 1.784 1 2.75 1h10.5c.966 0 1.75.784 1.75 1.75v7.5A1.75 1.75 0 0 1 13.25 12H9.06l-2.573 2.573A1.458 1.458 0 0 1 4 13.543V12H2.75A1.75 1.75 0 0 1 1 10.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h2a.75.75 0 0 1 .75.75v2.19l2.72-2.72a.749.749 0 0 1 .53-.22h4.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z">
                                </path>
                            </svg>
                            Comment
                        </button>
                    </a>
                    <a href="#" class="text-secondary" data-bs-toggle="collapse"
                        data-bs-target="#commentForm{{ $post->id }}" aria-expanded="false"
                        aria-controls="commentForm{{ $post->id }}">
                        <button class="btn btn-outline-dark rounded-pill">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"
                                fill="currentColor   ">
                                <path
                                    d="M6.78 1.97a.75.75 0 0 1 0 1.06L3.81 6h6.44A4.75 4.75 0 0 1 15 10.75v2.5a.75.75 0 0 1-1.5 0v-2.5a3.25 3.25 0 0 0-3.25-3.25H3.81l2.97 2.97a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215L1.47 7.28a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z">
                                </path>
                            </svg>
                            Reply
                        </button>
                    </a>

                    {{-- Comment Form --}}
                    <div class="collapse mt-2" id="commentForm{{ $post->id }}">
                        <form action="{{ Route('replys.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_post" value="{{ $post->id }}">
                            <div class="mb-3">
                                <textarea name="reply" class="form-control" rows="3"
                                    placeholder="Your Comment..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="replyImage{{ $post->id }}" class="form-label">Unggah Gambar atau
                                    Video</label>
                                <input type="file" name="gambar" class="form-control" id="replyImage{{ $post->id }}"
                                    accept="image/*,video/*">
                            </div>
                            <button type="submit" class="btn btn-dark rounded-pill px-3 mb-3">Send</button>
                        </form>
                    </div>

                    {{-- List Post Comment --}}
                    <div class="collapse mt-2" id="commentList{{ $post->id }}">
                        @foreach ($post->replys as $reply)
                        <div class="border rounded-3 p-2 mb-2">
                            <img src="{{ $reply->user->profil_pic ? asset('storage/' . $reply->user->profil_pic) : asset('/img/default-profile.png') }}"
                                class="user-image rounded-circle mb-3" style="width: 50px; height: 50px;" alt="">
                            <strong class="ms-3">{{ $reply->user->username }}</strong>
                            &#x2022; {{-- Dot Symbol --}}
                            <!-- Menampilkan Waktu -->
                            <small class="text-muted" style="font-size:small">
                                {{ $reply->created_at->diffForHumans() }}
                            </small>
                            {{-- Cek jika ada parent untuk reply --}}
                            @if ($reply->id_parent)
                                @php
                                    // Mendapatkan komentar parent berdasarkan id_parent
                                    $parentReply = $post->replys->firstWhere('id', $reply->id_parent);
                                @endphp
                                @if ($parentReply)
                                    <p class="text-muted small">
                                        <strong>Membalas pesan dari {{ $parentReply->user->username }}</strong>
                                    </p>
                                    <p class="text-muted small">
                                        <strong class="border-start border-4 ms-2 ps-3">{{ $parentReply->reply }}</strong>
                                    </p>
                                @endif
                            @endif
                            <p>{{ $reply->reply }}</p>
                            @if ($reply->gambar)
                            <div class="mb-3">
                                @if (strpos($reply->gambar, '.mp4') !== false || strpos($reply->gambar, '.mov') !==
                                false)
                                <video controls class="img-fluid">
                                    <source src="{{ asset('storage/' . $reply->gambar) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                @else
                                <img src="{{ asset('storage/' . $reply->gambar) }}" alt="Reply Image" class="img-fluid">
                                @endif
                            </div>
                            @endif

                            {{-- Reply Button --}}
                            <a href="#" class="text-secondary" data-bs-toggle="collapse"
                                data-bs-target="#replyForm{{ $reply->id }}" aria-expanded="false"
                                aria-controls="replyForm{{ $reply->id }}">
                                <button class="btn btn-outline-dark rounded-pill">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"
                                        fill="currentColor">
                                        <path
                                            d="M6.78 1.97a.75.75 0 0 1 0 1.06L3.81 6h6.44A4.75 4.75 0 0 1 15 10.75v2.5a.75.75 0 0 1-1.5 0v-2.5a3.25 3.25 0 0 0-3.25-3.25H3.81l2.97 2.97a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215L1.47 7.28a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z">
                                        </path>
                                    </svg>
                                    Reply
                                </button>
                            </a>

                            {{-- Reply Form --}}
                            <div class="collapse mt-2" id="replyForm{{ $reply->id }}">
                                <form action="{{ Route('replys.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id_post" value="{{ $post->id }}">
                                    <input type="hidden" name="id_reply" value="{{ $reply->id }}">
                                    <div class="mb-3">
                                        <textarea name="reply" class="form-control" rows="3"
                                            placeholder="Your Reply..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="replyImage{{ $reply->id }}" class="form-label">Unggah Gambar atau
                                            Video</label>
                                        <input type="file" name="gambar" class="form-control"
                                            id="replyImage{{ $reply->id }}" accept="image/*,video/*">
                                    </div>
                                    <button type="submit" class="btn btn-dark rounded-pill px-3 mb-3">Send</button>
                                </form>
                            </div>
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