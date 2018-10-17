@extends('layouts.base')

@section('content')
    <div>
        <div class="card">
            <div class="card-header">
                Asked By, <strong>{{ $discussion->user->name }}</strong>
                <button class="badge badge-primary" disabled="disabled">Point: {{ $point->point }}</button>
                <span> | {{ $discussion->created_at->diffForHumans() }} ago</span>
                @if (!$best_answer)
                    @if ($discussion->is_being_watched())
                        <a href="{{ route('discussion.unwatch', ['id' => $discussion->id]) }}" class="btn btn-warning btn-sm">Unwatch</a>
                    @else 
                        <a href="{{ route('discussion.watch', ['id' => $discussion->id]) }}" class="btn btn-success btn-sm">Watch</a>
                    @endif
                @else
                    <button disabled="disabled" class="btn btn-danger btn-sm">Closed</button>
                @endif
            </div>
            
            <div class="card-body">
                    <h4 class="card-title">Question: <u>{{ $discussion->title }} ?</u></h4>
                    <p class="card-text">{{ $discussion->content }}</p>

                    @if ($best_answer)
                        <div class="card">
                            <div class="card-header text-white bg-warning text-center">
                                <h2><b><u>Best Answer</u></b></h2>
                            </div>
                            <div class="card-body">
                                <h3><strong>{{ $best_answer->user->name }}</strong></h3>
                                <p>{{ $best_answer->content }}</p>
                            </div>
                            <div class="card-footer text-center">
                                    <span class="">
                                        <strong>
                                            {{ $best_answer->likes->count() }} people liked this answer
                                        </strong>
                                    </span>
                            </div>
                            <div class="card_body"></div>
                        </div>
                    @endif
            </div>
            <div class="card-footer text-muted">
                <div class="row">
                    <div class="col-md-6"><b>{{ $discussion->replies->count() }} replies</b></div>
                </div>
            </div>
        </div>
       <hr>
        {{-- /////////////////////////// --}}
        {{-- REPLY FORM --}}
        {{-- /////////////////////////// --}}
        @if (!$best_answer)
            <div class="reply-form">
                <form action="{{ route('discussions.reply', ['id' => $discussion->id])}}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input name="content" type="text" class="form-control" placeholder="Leave a reply">
                    </div>
                    <div class="form-gorup">
                        <button class="btn btn-light btn-block text-primary">
                            Reply
                        </button>
                    </div>
                </form>
            </div>
        @endif
        <br>
        <h4 class="text-center">Replies </h4>
        @foreach ($discussion->replies as $reply)
            <div class="card border-light">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3><strong>{{ $reply->user->name }}</strong></h3>
                            
                        </div>
                        <div class="col-md-4">
                            {{-- /////////////////////////// --}}
                            {{-- MARKING AS BEST ANSWER --}}
                            {{-- /////////////////////////// --}}
                            @if (!$best_answer && $discussion->user->id === Auth::user()->id)
                            <a href="{{ route('discussion.best-reply', ['id' => $reply->id])}}" 
                                class="btn btn-sm btn-info float-right" 
                                style="border-radius: 15px">Mark as best answer</a>
                            @endif
                        </div>
                    </div>
                    <p>{{ $reply->content }}</p>
                    {{-- /////////////////////////// --}}
                    {{-- COUNT THE NUMBER OF LIKES --}}
                    {{-- /////////////////////////// --}}
                    @if ($reply->is_liked_by_auth_user())
                        <a href="{{ route('reply.unlike', ['id' => $reply->id]) }}" class="btn btn-warning btn-xs"
                            style="border-radius: 20px">
                            Unlike
                            <span class="badge badge-light" style="border-radius: 8px">
                                <strong>{{ $reply->likes->count() }}</strong>
                            </span>
                        </a>
                    @else 
                        <a href="{{ route('reply.like', ['id' => $reply->id]) }}" class="btn btn-success btn-xs"
                            style="border-radius: 20px">
                            Like 
                            <span class="badge badge-light" style="border-radius: 8px">
                                <strong>{{ $reply->likes->count() }}</strong>
                            </span>
                        </a>
                    @endif
                </div>
            </div>
            <br>
        @endforeach
    </div>
@endsection