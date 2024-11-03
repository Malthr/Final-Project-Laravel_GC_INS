<nav class="navbar navbar-expand-lg">
    <!--begin::Container-->
    <div class="container-fluid">
        <a class="navbar-brand" href="">
            <img alt="Logo Png">
            Our Company
        </a>

        <form class="mx-auto" style="width: 60vh;">
            <input class="form-control py-2 rounded-pill" type="text" placeholder="Search" aria-label="Search"
                aria-describedby="search-icon">
        </form>

        <ul class="navbar-nav ms-auto">
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