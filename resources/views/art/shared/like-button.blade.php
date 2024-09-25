<div class="mt-2">
    @if (session()->has('auth_user'))
        @if (collect($art['likes'])->contains(function ($like) {
                return $like['user_id'] === session('auth_user.id');
            }))
            <form action="{{ route('art.unlike', $art['id']) }}" method="post">
                @csrf
                <button type="submit" class="fw-light text-danger nav-link fs-6">
                    <span class="fas fa-heart me-1"></span> {{ count($art['likes']) }}
                </button>
            </form>
        @else
            <form action="{{ route('art.like', $art['id']) }}" method="post">
                @csrf
                <button type="submit" class="fw-light text-danger nav-link fs-6">
                    <span class="far fa-heart me-1"></span> {{ count($art['likes']) }}
                </button>
            </form>
        @endif
    @else
        <a href="{{ route('login') }}" class="fw-light text-danger nav-link fs-6">
            <span class="far fa-heart me-1"></span> {{ count($art['likes']) }}
        </a>
    @endif
</div>
