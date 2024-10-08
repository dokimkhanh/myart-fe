<div class="card-header pb-0 border-0">
    <h5 class="">Who to follow</h5>
</div>
<div class="card-body">
    @foreach ($topUsers as $user)
        <div class="hstack gap-2 mb-3">
            <div class="avatar">
                <a href="#!">
                    <img style="width: 50px;" class="avatar-img rounded-circle"
                        src="{{ env('SERVER_ENDPOINT') . '/' . $user['profile_photo_path'] }}" alt="">
                </a>
            </div>
            <div class="overflow-hidden">
                <a class="h6 mb-0" href="{{ Route('user.show', $user['id']) }}">{{ $user['name'] }}</a>
                <p class="mb-0 small text-truncate">&#64;{{ $user['username'] }}</p>
            </div>
            <a class="btn btn-primary-soft rounded-circle icon-md ms-auto" href="#"><i class="fa-solid fa-plus">
                </i></a>
        </div>
    @endforeach
    <div class="d-grid mt-3">
        <a class="btn btn-sm btn-primary-soft" href="#!">Show More</a>
    </div>
</div>
