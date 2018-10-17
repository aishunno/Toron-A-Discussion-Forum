@extends('layouts.base')
    @section('content')
        <h2>Edit Topic</h2>
        <form action="{{ route('topics.update', ['topic' => $topic->id ]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <input 
                    value="{{ $topic->title }}"
                    type="text" name="topic" class="form-control">
            </div>
            <button class="btn btn-success" type="submit">Update Topic</button>
        
        </form>
    @endsection
