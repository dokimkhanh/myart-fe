@extends('layout.layout')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-3">
                @include('shared.left-sidebar')
            </div>
            <div class="col-6">
                <form enctype="multipart/form-data" action="{{ route('user.update', $user['id']) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="px-3 pt-4 pb-2">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img style="width:150px" class="me-3 avatar-sm rounded-circle"
                                        src="{{ env('SERVER_ENDPOINT') . '/' . $user['profile_photo_path'] }}"
                                        alt="{{ $user['name'] }} Avatar">

                                    <div>
                                        <h3 class="card-title mb-0 text-primary">
                                            <input type="text" name="name" id="name" value="{{ $user['name'] }}">
                                        </h3>
                                        <span class="fs-6 text-muted">
                                            <span>&#64;</span>{{ $user['username'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    @if (isset(session('auth_user')['id']) && session('auth_user')['id'] == $user['id'] || session('auth_user')['is_admin'] == true)
                                        <a href="{{ session('auth_user')['id'] == $user['id'] ? route('profile') : route('user.show', $user['id']) }}" class="btn btn-link btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="px-2 mt-4">
                                <div class="d-flex justify-content-start">
                                    <a href="#" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-user me-1">
                                        </span> {{ count($user['followers']) }} Followers </a>
                                    <a href="#" class="fw-light nav-link fs-6 me-3"> <span class="fas fa-pen me-1">
                                        </span> {{ count($user['arts']) }} Arts</a>
                                    <a href="#" class="fw-light nav-link fs-6"> <span class="fas fa-comment me-1">
                                        </span> {{ count($user['comments']) }} Comments</a>
                                </div>
                                <div class="mb-3 mt-4">
                                    <label for="formFileSm" class="form-label">Upload Avatar</label>
                                    <input name="profile_photo" class="form-control form-control-sm" id="formFileSm"
                                        type="file">
                                </div>
                                <h5 class="fs-5 mt-2"> About </h5>
                                <div class="mb-2">
                                    <textarea name="bio" rows="3" id="bio" class="form-control fs-6 fw-light">{{ $user['bio'] }}</textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm ms-3"> Update </button>
                        </div>
                    </div>
                </form>
                <hr>
            </div>
            <div class="col-3">
                <div class="card">
                    @include('shared.follow-box')
                </div>
            </div>
        </div>
    </div>
@endsection
