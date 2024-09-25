@extends('layout.layout')
@section('title', 'Profile')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-3">
                @include('shared.left-sidebar')
                <div class="card mt-3">
                    @include('shared.follow-box')
                </div>
            </div>
            <div class="col-9">
                @include('shared.notification-message')
                <div class="card">
                    <div class="px-3 pt-4 pb-2">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img style="width:150px" class="me-3 avatar-sm rounded-circle"
                                    src="{{ env('SERVER_ENDPOINT') . '/' . $user['profile_photo_path'] }}"
                                    alt="{{ $user['name'] }} Avatar">
                                <div>
                                    <h3 class="card-title mb-0 text-primary">
                                        {{ $user['name'] }}
                                        @if ($user['email_verified_at'] !== null)
                                            <i class="fas fa-check-circle text-primary"></i>
                                        @endif
                                    </h3>
                                    <span class="fs-6 text-muted">&#64;{{ $user['username'] }}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                @if (session()->has('auth_user'))
                                    @if ($user['id'] == session()->get('auth_user')['id'] || session('auth_user')['is_admin'] == true)
                                        <a href="{{ route('user.edit', $user['id']) }}" class="btn btn-link btn-sm">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="px-2 mt-4">
                            <div class="d-flex justify-content-start">
                                @include('users.shared.user-stats')
                                @if (isset(session('auth_user')['id']))
                                    @if (session('auth_user')['id'] !== $user['id'])
                                        @if ($checkFollow === true)
                                            <form action="{{ route('user.unfollow', $user['id']) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm ms-3"> Unfollow
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('user.follow', $user['id']) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm ms-3"> Follow </button>
                                            </form>
                                        @endif
                                    @endif

                                @endif

                            </div>
                            <h5 class="fs-5 mt-2"> About : </h5>
                            <p class="fs-6 fw-light">
                                {{ $user['bio'] }}
                            </p>
                        </div>
                    </div>
                </div>
                <hr>

                @if (empty($user['arts']))
                    <p class="text-center">No art here...</p>
                @else
                    @foreach ($user['arts'] as $art)
                        <div class="mt-3">
                            @include('shared.art-card', ['art' => $art])
                        </div>
                    @endforeach
                @endif
                <div class="mt-3">
                    {{-- {{ $user['arts']->links() }} --}}
                </div>
            </div>

        </div>
    </div>
@endsection
