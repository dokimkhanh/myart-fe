@extends('layout.layout')
@section('title', 'Users')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-3">
                @include('admin.shared.left-sidebar')
            </div>
            <div class="col-9">
                <h1>Comments</h1>
                <table class="table table-striped table-hover mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">User</th>
                            <th scope="col">Art</th>
                            <th scope="col" style="width: 40%">Content</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)
                            <tr>
                                <th scope="row">{{ $comment['id'] }}</th>
                                <td><a href="{{ route('user.show', $comment['user']['id']) }}"
                                        class="text-decoration-none">{{ $comment['user']['name'] }}</a> </td>
                                <td><a href="{{ route('art.show', $comment['art']['id']) }}"
                                        class="text-decoration-none">{{ $comment['art']['content'] }}</a></td>
                                <td>{{ $comment['content'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($comment['created_at'])->format('Y-m-d H:i:s') }}
                                   ({{ \Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }})</td>
                                <td>
                                    <form action="{{ route('admin.comments.destroy', $comment['id']) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete?')" name="delete" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($pagination['total_pages'] > 1)
                    <div class="pagination pagination-sm">
                        @if ($pagination['prev_page_url'])
                            <a class="page-link"
                                href="{{ route('admin.comments.index', ['page' => $pagination['current_page'] - 1, 'query' => $query]) }}">Previous</a>
                        @endif

                        @for ($i = 1; $i <= $pagination['total_pages']; $i++)
                            <a class="page-link"
                                href="{{ route('admin.comments.index', ['page' => $i, 'query' => $query]) }}"
                                class="{{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        @if ($pagination['next_page_url'])
                            <a class="page-link"
                                href="{{ route('admin.comments.index', ['page' => $pagination['current_page'] + 1, 'query' => $query]) }}">Next</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
