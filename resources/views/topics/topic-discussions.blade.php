@extends('layouts.base')

@section('content')
@foreach ($discussions as $discussion)
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8">
                Asked By, <strong>{{ $discussion->user->name }}</strong>
                <span> | {{ $discussion->created_at->diffForHumans() }} ago</span>
            </div>
        </div>
    </div>
    
    <div class="card-body">
            <a href="{{ route('discussions.show', ['slug' => $discussion->slug]) }}"><h4 class="card-title">Question: <u>{{ $discussion->title }} ?</u></h4></a>
            <p class="card-text">{{ str_limit($discussion->content, 250) }}</p>
    </div>
    <div class="card-footer text-muted">
        <div class="row">
            <div class="col-md-6"><b>{{ $discussion->replies->count() }} replies</b></div>
        </div>
    </div>  
</div>
<br>
@endforeach
@endsection