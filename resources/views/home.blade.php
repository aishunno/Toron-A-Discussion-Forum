@extends('layouts.app')

@section('sidebar')
    <h3>Topics</h3>
    <ul class="list-group">
        @foreach ($topics as $topic)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $topic->title }}
                <span class="badge badge-primary badge-pill">14</span>
            </li>
        @endforeach
    </ul>
@endsection

@section('content')
    <div  class="card mb-3">
        <div class="card-header">Dashboard</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            You are logged in!
        </div>
    </div>
@endsection
