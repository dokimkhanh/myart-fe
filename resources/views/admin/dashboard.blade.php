@extends('layout.layout')
@section('title', 'Dashboard')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-3">
                @include('admin.shared.left-sidebar')
            </div>
            <div class="col-9">
                <h1>Dashboard</h1>
                <div class="row">
                    @include('admin.shared.widget', [
                        'title' => 'Total Users',
                        'icon' => 'fas fa-user',
                        'data' => $res_data['user_count'],
                    ])
                    @include('admin.shared.widget', [
                        'title' => 'Total Arts',
                        'icon' => 'fas fa-pen',
                        'data' => $res_data['art_count'],
                    ])
                    @include('admin.shared.widget', [
                        'title' => 'Total Comments',
                        'icon' => 'fas fa-comment',
                        'data' => $res_data['comment_count'],
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
