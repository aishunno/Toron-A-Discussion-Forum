@extends('layouts.base')

@section('content')
    <ul class="list-group">
        @foreach ($topics as $topic)
            <li class="list-group-item text-primary">
                <div class="row">
                    <div class="col-md-8">
                        <strong>{{ $topic->title }}</strong>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('topics.edit', ['id' => $topic->id])}}" class="btn btn-secondary">Edit</a>
                            </div>
                            
                            <div class="col-md-6">
                                <form action="{{ route('topics.destroy', ['topic' => $topic->id])}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <br>
        @endforeach
    </ul>
    <br>
@endsection