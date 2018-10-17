<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Like;
use Auth;
use App\User;
use App\Point;
use Session;

class RepliesController extends Controller
{
    public function like($id)
    {
        Like::create([
            'reply_id' => $id,
            'user_id'  => Auth::id()
        ]);

        Session::flash('success', 'You liked the reply');

        return redirect()->back();
    }
    
    public function unlike($id)
    {
        $like = Like::where('reply_id', $id)->where('user_id', Auth::id())->first();
        $like->delete();

        Session::flash('success', 'You unliked the reply');

        return redirect()->back();
    }

    public function best_answer($id) {
        $reply = Reply::find($id);
        $reply->best_answer = 1;
        $reply->save();

        $point = Point::where('user_id', $reply->user_id)->first();
        if ($point) {
            $point->point += 10;
            $point->save();
        } else {
            Point::create([
                'user_id' => $reply->user_id,
                'point' => 10
            ]);
        }

        Session::flash('success', 'Reply has been marked as best answer');

        return redirect()->back();
    }
}
