<nav class="navbar navbar-expand-lg">
    <!--begin::Container-->
    <div class="container-fluid">
        <p class="mb-0">
            <a class="navbar-brand text-light" href="{{route('homepage')}}">
                <img class="user-image rounded-circle me-2" src="/img/logo-2.png" alt="Logo Png" style="width:35px">
                Our Opinion
            </a>
        </p>

        <form style="width: 60vh;">
            <input class="form-control py-2 rounded-pill" type="text" placeholder="Search" aria-label="Search"
                aria-describedby="search-icon">
        </form>

        <ul class="navbar-nav">
            <li>
                <form action="{{Route ('post.create')}}">
                    <button class="btn btn-outline-light rounded-pill">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16" fill="currentColor"><path d="M7.75 2a.75.75 0 0 1 .75.75V7h4.25a.75.75 0 0 1 0 1.5H8.5v4.25a.75.75 0 0 1-1.5 0V8.5H2.75a.75.75 0 0 1 0-1.5H7V2.75A.75.75 0 0 1 7.75 2Z"></path></svg>
                        Create Post
                    </button>
                </form>
            </li>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle show" data-bs-toggle="dropdown">
                    <img src="/img/user2-160x160.jpg" class="user-image rounded-circle" alt="User Image">
                </a>

                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header"> <img src="/img/user2-160x160.jpg" class="rounded-circle shadow"
                            alt="User Image">
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