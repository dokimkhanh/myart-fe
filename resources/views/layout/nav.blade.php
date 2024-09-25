<nav class="navbar navbar-expand-lg bg-dark border-bottom border-bottom-dark ticky-top bg-body-tertiary"
    data-bs-theme="dark">
    <div class="container">
        <a class="navbar-brand fw-light" href="/"><span class="fas fa-paintbrush me-1"> </span>
            {{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                @if (!session()->has('auth_user'))
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('login') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('auth.register') ? 'active' : '' }}"
                            href="{{ route('auth.register') }}">Register</a>
                    </li>
                @else
                    @if (session('auth_user')['is_admin'] == 1)
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.dashboard') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                <i class="fa-solid fa-user-shield me-1"></i> Admin Panel
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                            <img class="avatar avatar-xs rounded-circle border border-white" width="30"
                                src="{{ env('SERVER_ENDPOINT') . '/' . session('auth_user')['profile_photo_path'] }}">
                            {{ session('auth_user')['name'] }}</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="nav-link" type="submit">Logout</button>
                        </form>
                    </li>

                @endif
            </ul>
        </div>
    </div>
</nav>
