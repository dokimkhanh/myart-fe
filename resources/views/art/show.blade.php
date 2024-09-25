@extends('layout.layout')
@section('title', 'Art')
@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-3">
                @include('shared.left-sidebar')
            </div>
            <div class="col-6">
                @include('shared.notification-message')

                <div class="">
                    @include('shared.art-card')
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    @include('shared.search-bar')
                </div>
                <div class="card mt-3">
                    @include('shared.follow-box')
                </div>
            </div>
        </div>
    </div>
@endsection
