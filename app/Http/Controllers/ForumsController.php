<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discussion;
use App\Topic;
use Session;

class ForumsController extends Controller
{
    public function index()
    {
        $discussions = Discussion::orderBy('created_at', 'desc')->paginate(4);
        return view('forum.index')->with('discussions', $discussions);
    }

    public function topic($id) {
        $topic = Topic::where('id', $id)->first();

        return view('topics.topic-discussions')->with('discussions', $topic->discussions()->orderBy('created_at', 'desc')->paginate(4));
    }
}
