@extends('layouts.base')
    @section('content')
        <h2>Create New Channel</h2>
        <div class="container">
        <form action="{{ route('topics.store') }}" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <input type="text" name="topic" class="form-control">
            </div>

            <div class="form-group">
                <button class="btn btn-success" type="submit">Save Topic</button>
            </div>
        </form>
        </div>
    @endsection
