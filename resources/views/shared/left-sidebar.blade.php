<div class="card overflow-hidden">
    <div class="card-header pb-0 border-0 ">
        <h5 class="">Settings</h5>
    </div>

    <div class="card-body pt-3">

        <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
            <li class="nav-item">
                <a class="{{ Route::is('dashboard') ? 'text-white bg-dark rounded' : 'text-dark' }} nav-link"
                    href="{{ route('dashboard') }}">
                    <span>Home</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::is('feed') ? 'text-white bg-dark rounded' : 'text-dark' }} nav-link"
                    href="{{ route('feed') }}">
                    <span>Feed</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <span>Settings</span></a>
            </li>
        </ul>
    </div>

</div>
