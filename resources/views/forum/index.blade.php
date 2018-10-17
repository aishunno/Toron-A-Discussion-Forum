@extends('layouts.base')

@section('content')
    
    @foreach ($discussions as $discussion)
        <div class="card">
            <div class="card-header">
                Asked By, <strong>{{ $discussion->user->name }}</strong>
                <span> | {{ $discussion->created_at->diffForHumans() }} ago</span>
            </div>
            <div class="card-body">
                    <a href="{{ route('discussions.show', ['slug' => $discussion->slug]) }}"><h4 class="card-title">Question: <u>{{ $discussion->title }} ?</u></h4></a>
                    <p class="card-text">{{ str_limit($discussion->content, 250) }}</p>
            </div>
            <div class="card-footer text-muted">

                <b class="float-right">{{ $discussion->replies->count() }} replies</b>
            </div>
        </div> <br>
    @endforeach
    <div class="text-center">
        {{ $discussions->links() }}
    </div>
@endsection