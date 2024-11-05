<nav class="navbar navbar-expand-lg">
    <!--begin::Container-->
    <div class="container-fluid">
        <p class="mb-0">
            <a class="navbar-brand text-light" href="{{route('homepage')}}">
                <img class="user-image rounded-circle me-2" src="/img/logo-2.png" alt="Logo Png" style="width:35px">
                Our Opinion
            </a>
        </p>

        <!-- Search bar dengan AJAX untuk menampilkan hasil secara real-time -->
        <form style="width: 60vh;" action="{{ route('search') }}" method="GET">
            <input id="search-input" class="form-control py-2 rounded-pill" type="text" name="query"
                placeholder="Search for topics or users" aria-label="Search" aria-describedby="search-icon"
                autocomplete="off">
            <!-- Container untuk hasil pencarian dropdown -->
            <div id="search-results" class="dropdown-menu w-100" style="display: none;"></div>
        </form>


        <ul class="navbar-nav">
            <li>
                <form action="{{Route ('post.create')}}">
                    <button class="btn btn-outline-light rounded-pill">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16"
                            fill="currentColor">
                            <path
                                d="M7.75 2a.75.75 0 0 1 .75.75V7h4.25a.75.75 0 0 1 0 1.5H8.5v4.25a.75.75 0 0 1-1.5 0V8.5H2.75a.75.75 0 0 1 0-1.5H7V2.75A.75.75 0 0 1 7.75 2Z">
                            </path>
                        </svg>
                        Create Post
                    </button>
                </form>
            </li>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle show" data-bs-toggle="dropdown">
                    <img src="{{ asset($user->profil_pic ? 'storage/' . $user->profil_pic : 'img/avatar.png') }}" class="user-image rounded-circle" alt="Profile Picture">
                </a>

                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header"> 
                        <img src="{{ $user->profil_pic ? asset('storage/' . $user->profil_pic) : asset('../img/default-profile.png') }}" class="user-image rounded-circle" alt="">
    
                        <p>
                            {{$user->username}}
                        </p>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{route('profile.edit')}}">View Profile</a>
                    </li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                            this.closest('form').submit();">
                                Logout
                            </a>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<!-- Script AJAX untuk real-time search -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#search-input').on('keyup', function() {
        let query = $(this).val();

        if (query.length > 1) { // Hanya mencari jika query lebih dari 1 karakter
            $.ajax({
                url: "{{ route('search') }}",
                method: "GET",
                data: { query: query },
                success: function(data) {
                    let results = '';

                    // Cek jika ada hasil user
                    if (data.users.length > 0) {
                        results += '<h6 class="dropdown-header">Users</h6>';
                        data.users.forEach(user => {
                            results += `<a href="#" class="dropdown-item" onclick="filterPostsByUser(${user.id})">${user.username}</a>`;
                        });
                    }

                    // Cek jika ada hasil topik
                    if (data.topics.length > 0) {
                        results += '<h6 class="dropdown-header">Topics</h6>';
                        data.topics.forEach(topic => {
                            results += `<a href="#" class="dropdown-item" onclick="filterPostsByTopic(${topic.id})">${topic.topik}</a>`;
                        });
                    }

                    // Tampilkan hasil di dropdown
                    $('#search-results').html(results).show();
                }
            });
        } else {
            $('#search-results').hide(); // Sembunyikan dropdown jika query kosong
        }
    });

    // Sembunyikan dropdown saat klik di luar
    $(document).click(function(event) {
        if (!$(event.target).closest('#search-input').length) {
            $('#search-results').hide();
        }
    });
});

function filterPostsByUser(userId) {
    $.ajax({
        url: "{{ route('search') }}",
        method: "GET",
        data: { id_user: userId },
        success: function(data) {
            updatePosts(data.posts);
            $('#search-results').hide();
        }
    });
}

function filterPostsByTopic(topicId) {
    $.ajax({
        url: "{{ route('search') }}",
        method: "GET",
        data: { id_topik: topicId },
        success: function(data) {
            updatePosts(data.posts);
            $('#search-results').hide();
        }
    });
}

// Fungsi untuk memperbarui bagian #posts-container dengan hasil pencarian
function updatePosts(posts) {
    let postsHtml = '';

    if (posts.length > 0) {
        posts.forEach(post => {
            postsHtml += `<div class="post-item">
                            <h5>${post.title}</h5>
                            <p>${post.content}</p>
                            <p><strong>By:</strong> ${post.user.username}</p>
                          </div>`;
        });
    } else {
        postsHtml = '<p>No results found</p>';
    }

    $('#posts-container').html(postsHtml);
}

</script>