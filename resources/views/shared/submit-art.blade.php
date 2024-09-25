<h4> Share your something </h4>
@if (!session()->has('auth_user'))
    <div class="alert alert-warning" role="alert">
        <p class="mb-0">
            <a href="{{ route('login') }}">Login</a> or <a href="{{ route('auth.register') }}">Register</a>
            to share your art
        </p>
    </div>
@else
    <div class="row">
        <form enctype="multipart/form-data" action="{{ route('art.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <textarea name="content" class="form-control" id="art" rows="3"></textarea>
                @error('content')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <div class="input-group mt-3">
                    <input type="file" name="image" class="form-control" id="image" aria-label="Upload">
                </div>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-dark btn-sm btn-block"> Share </button>
            </div>
        </form>
    </div>
@endif
