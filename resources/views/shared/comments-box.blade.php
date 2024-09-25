<div>

    @if (count($comments) !== 0)
        <hr>
    @endif

    @if (session()->has('auth_user'))
        <form action="{{ route('art.comment.store', $art['id']) }}" method="post">
            <div class="mb-3 mt-3">
                @csrf
                <input class="fs-6 form-control" name="comment" type="text" placeholder="...">
                @error('comment')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-sm"> Post Comment </button>
            </div>
        </form>
    @endif

    @if (count($comments) > 0)
        @foreach ($comments as $comment)
            {{-- @dd($arts); --}}
            <div class="d-flex align-items-start">
                <img style="width:35px" class="me-2 avatar-sm rounded-circle"
                    src="{{ env('SERVER_ENDPOINT') . '/' . $comment['user']['profile_photo_path'] }}"
                    alt="{{ $comment['user']['name'] }} Avatar">
                <div class="w-100">
                    <div class="d-flex justify-content-between">
                        <h6 class="">
                            <a
                                href="{{ session()->has('auth_user') && $comment['user']['id'] == session()->get('auth_user')['id'] ? route('profile') : route('user.show', $comment['user']['id']) }}">
                                {{ $comment['user']['name'] }}
                            </a>
                        </h6>
                        <small class="fs-6 fw-light text-muted">
                            {{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}</small>
                    </div>
                    <p class="fs-6 fw-light">
                        {{ $comment['content'] }}
                    </p>
                </div>
                <div class="d-flex justify-content-end">
                    @if (session()->has('auth_user') &&
                            (session('auth_user')['id'] == $comment['user']['id'] || session('auth_user')['is_admin'] == true))
                        <form action="{{ route('art.comment.destroy',  ['art' => $art['id'], 'comment' => $comment['id']]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-link p-0" onclick="return confirm('Are you sure?')">
                                <i class="fa-solid fa-xmark text-danger"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
