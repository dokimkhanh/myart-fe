<div class="card-header pb-0 border-0">
    <h5 class="">Search</h5>
</div>
<div class="card-body">
    <form action="{{ route('dashboard') }}" method="get">
        {{-- <input placeholder="..." class="form-control w-100" value="{{ request('search') }}" type="text" name="search"> --}}
        <input type="text" class="form-control w-100" name="query" value="{{ request('query') }}" placeholder="Search arts">
        <button class="btn btn-dark mt-2"> Search</button>
    </form>
</div>
