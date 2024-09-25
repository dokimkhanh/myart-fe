@extends('layout.layout')
@section('title', 'Dashboard')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-3">

                @include('shared.left-sidebar')

                <div class="card mt-3">
                    @include('shared.search-bar')
                </div>
                <div class="card mt-3">
                    @include('shared.follow-box')
                </div>
            </div>
            <div class="col-9">
                @include('shared.notification-message')
                @include('shared.submit-art')
                <hr>
                @if (empty($arts))
                    <p class="text-center">No art here...</p>
                @else
                    @foreach ($arts as $art)
                        <div class="mt-3">
                            @include('shared.art-card', ['art' => $art])
                        </div>
                    @endforeach
                @endif
                <div class="mt-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            @if (!empty($arts))
                                @if ($pagination['total_pages'] > 1)
                                    <div class="pagination">
                                        @if ($pagination['prev_page_url'])
                                            <a class="page-link"
                                                href="{{ route('feed', ['page' => $pagination['current_page'] - 1, 'query' => $query]) }}">Previous</a>
                                        @endif

                                        @for ($i = 1; $i <= $pagination['total_pages']; $i++)
                                            <a class="page-link"
                                                href="{{ route('feed', ['page' => $i, 'query' => $query]) }}"
                                                class="{{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                                {{ $i }}
                                            </a>
                                        @endfor

                                        @if ($pagination['next_page_url'])
                                            <a class="page-link"
                                                href="{{ route('feed', ['page' => $pagination['current_page'] + 1, 'query' => $query]) }}">Next</a>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
    </div>
@endsection
