@extends('layout.layout')
@section('title', 'Users')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-3">
                @include('admin.shared.left-sidebar')
            </div>
            <div class="col-9">
                <h1>Arts</h1>
                <table class="table table-striped table-hover mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Content</th>
                            <th scope="col">Image</th>
                            <th scope="col">By User</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arts as $art)
                            <tr>
                                <th scope="row">{{ $art['id'] }}</th>
                                <td><a href="{{ route('art.show', $art['id']) }}">{{ $art['content'] }}</a></td>
                                <td>
                                    @if ($art['image'] == null)
                                        NULL
                                    @else
                                        <img class="img-fluid" src="{{ env('SERVER_ENDPOINT') . '/' . $art['image'] }}"
                                            width="100">
                                    @endif
                                </td>
                                <td><a href="{{ route('user.show', $art['user']['id']) }}">{{ $art['user']['name'] }}</a>
                                </td>
                                <td>{{ $art['created_at'] }}</td>
                                <td>
                                    <a href="{{ route('art.show', $art['id']) }}" class="btn btn-primary btn-sm">View</a>
                                    <a href="{{ route('art.edit', $art['id']) }}" class="btn btn-primary btn-sm">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($pagination['total_pages'] > 1)
                    <div class="pagination">
                        @if ($pagination['prev_page_url'])
                            <a class="page-link"
                                href="{{ route('admin.arts.index', ['page' => $pagination['current_page'] - 1, 'query' => $query]) }}">Previous</a>
                        @endif

                        @for ($i = 1; $i <= $pagination['total_pages']; $i++)
                            <a class="page-link" href="{{ route('admin.arts.index', ['page' => $i, 'query' => $query]) }}"
                                class="{{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        @if ($pagination['next_page_url'])
                            <a class="page-link"
                                href="{{ route('admin.arts.index', ['page' => $pagination['current_page'] + 1, 'query' => $query]) }}">Next</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
