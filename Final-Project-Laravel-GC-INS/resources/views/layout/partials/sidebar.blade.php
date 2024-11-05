<div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white" style="position: fixed;  width:15%;">
    <a class="d-flex-fill align-items-center p-3 link-dark text-decoration-none border-bottom text-center">
        <span class="fs-3 fw-semibold">Topic</span>
    </a>
    <div class="list-group list-group-flush overflow-y-auto" style="max-height: calc(100dvh - 133px);">
        @foreach($topics as $topic)
        <a href="{{ route('homepage', ['id_topik' => $topic->id]) }}" class="list-group-item list-group-item-action"
            aria-current="true">
            <strong class="fs-5 mb-1"
                style="overflow:hidden; white-space:nowrap; text-overflow:ellipsis; display:block">
                {{ $topic->topik }}
            </strong>
            <div class="col-10 mb-1">{{ $topic->postingan_count }} Jumlah Post</div>
        </a>
        @endforeach
    </div>
</div>