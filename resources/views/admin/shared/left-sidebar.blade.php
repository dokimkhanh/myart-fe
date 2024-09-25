<div class="card overflow-hidden">
    <div class="card-footer text-center py-2">
        <h5 class="">Admin</h5>
    </div>
    <div class="card-body pt-3">
        <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
            <li class="nav-item">
                <a class="{{ Route::is('admin.dashboard') ? 'text-white bg-dark rounded' : 'text-dark' }} nav-link"
                    href="{{ route('admin.dashboard') }}">
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::is('admin.users.index') ? 'text-white bg-dark rounded' : 'text-dark' }} nav-link"
                    href="{{ route('admin.users.index') }}">
                    <span>Users</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::is('admin.arts.index') ? 'text-white bg-dark rounded' : 'text-dark' }} nav-link"
                    href="{{ route('admin.arts.index') }}">
                    <span>Arts</span></a>
            </li>
            <li class="nav-item">
                <a class="{{ Route::is('admin.comments.index') ? 'text-white bg-dark rounded' : 'text-dark' }} nav-link"
                    href="{{ route('admin.comments.index') }}">
                    <span>Comments</span></a>
            </li>
        </ul>
    </div>
</div>
