@extends('layouts.base')
@section('content')
<h2>Create Discussion</h2>
<form action="{{ route('discussions.update', ['id' => $discussion->id]) }}" method="POST">
    {{ csrf_field() }}

    <div class="form-group">
            <label for="title">Qustion</label>
            <input 
                name="title" 
                id="title" type="text" 
                class="form-control" 
                placeholder="Type your question"
                value=" {{ $discussion->title }} ">
    </div>

    <div class="form-group">
        <label for="topic_id">Select a topic</label>
        <select name="topic_id" id="topic_id" class="form-control">
            @foreach ($topics as $topic)
                <option value="{{ $topic->id }}">
                    {{ $topic->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="content">Describe it a bit</label>
        <textarea name="content" id="content" cols="30" rows="10" class="form-control">
            {{ $discussion->content }}
        </textarea>
    </div>
    <div class="form-group">
      <button class="btn btn-success" type="submit">Update Discussion</button>
    </div>
</form>
@endsection