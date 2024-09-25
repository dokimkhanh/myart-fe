<div class="card">
    <div class="px-3 pt-4 pb-2">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                {{-- @dd($art); --}}
                <img style="width:50px" class="me-2 avatar-sm rounded-circle"
                    src="{{ env('SERVER_ENDPOINT') . '/' . $art['user']['profile_photo_path'] }}"
                    alt="{{ $art['user']['name'] }} Avatar">
                <div>
                    <h5 class="card-title mb-0">
                        <a
                            href="{{ session()->has('auth_user') && $art['user']['id'] == session()->get('auth_user')['id'] ? route('profile') : route('user.show', $art['user']['id']) }}">
                            {{ $art['user']['name'] }}
                            @if ($art['user']['email_verified_at'] !== null)
                                <i class="fas fa-check-circle text-primary"></i>
                            @endif
                        </a>
                        <div>
                            <a href="{{ route('art.show', $art['id']) }}" class="fs-6 fw-light text-muted"> <span
                                    class="fas fa-clock"> </span>
                                {{ \Carbon\Carbon::parse($art['created_at'])->diffForHumans() }} </a>
                        </div>
                    </h5>
                </div>
            </div>
            <div>
                @if (session()->has('auth_user'))
                    @if (session()->get('auth_user')['id'] == $art['user']['id'] || session('auth_user')['is_admin'] == true)
                        <div class="dropdown">
                            <button class="btn btn-link dropdown" type="button" id="dropdownMenuOptions"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuOptions">
                                <li>
                                    <a class="dropdown-item" href="{{ route('art.edit', $art['id']) }}">Edit</a>
                                </li>
                                <li>
                                    <form action="{{ route('art.destroy', $art['id']) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal-{{ $art['id'] }}">Delete</button>
                                </li>
                                </form>
                            </ul>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="card-body">
        @if ($editing ?? false)
            <form enctype="multipart/form-data" action="{{ route('art.update', $art['id']) }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <textarea name="content" class="form-control" id="idea" rows="3">{{ $art['content'] }}</textarea>
                    @error('content')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="input-group mt-3">
                    <input type="file" name="image" class="form-control" id="image">
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-dark"> Update </button>
                </div>
            </form>
        @else
            @if ($art['image'] != null)
                <p class="fs-6 fw-light text-muted">
                    <img src="{{ env('SERVER_ENDPOINT') . '/' . $art['image'] }}" class="img-fluid rounded ">
                </p>
            @endif
            <p class="fs-6 fw-light text-muted">
                {{ $art['content'] }}
            </p>
        @endif
        <div class="d-flex justify-content-between">
            {{-- @dd($art); --}}
            @include('art.shared.like-button', ['art' => $art])
        </div>
        {{-- @dd($art); --}}
        @include('shared.comments-box', ['comments' => $art['comments']])
    </div>
</div>
