@extends('layout.layout')
@section('title', 'Users')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-3">
                @include('admin.shared.left-sidebar')
            </div>
            <div class="col-9">
                <h1>Users</h1>
                <table class="table table-striped table-hover mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Picture</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Joined At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td scope="row">{{ $user['id'] }}</td>
                                <td><img class="border border-danger rounded-circle" src="{{ env('SERVER_ENDPOINT') . '/' . $user['profile_photo_path'] }}" width="50"></td>
                                <td><a href="{{ route('user.show', $user['id']) }}">{{ $user['name'] }}</a></td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['created_at'] }}</td>
                                <td>
                                    <a href="{{ route('user.show', $user['id']) }}" class="btn btn-primary btn-sm">View</a>
                                    <a href="{{ route('user.edit', $user['id']) }}" class="btn btn-primary btn-sm">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($pagination['total_pages'] > 1)
                    <div class="pagination pagination-sm">
                        @if ($pagination['prev_page_url'])
                            <a class="page-link"
                                href="{{ route('admin.users.index', ['page' => $pagination['current_page'] - 1, 'query' => $query]) }}">Previous</a>
                        @endif

                        @for ($i = 1; $i <= $pagination['total_pages']; $i++)
                            <a class="page-link" href="{{ route('admin.users.index', ['page' => $i, 'query' => $query]) }}"
                                class="{{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        @if ($pagination['next_page_url'])
                            <a class="page-link"
                                href="{{ route('admin.users.index', ['page' => $pagination['current_page'] + 1, 'query' => $query]) }}">Next</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
