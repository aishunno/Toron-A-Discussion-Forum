<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discussion;
use App\Reply;
use App\User;
use App\Topic;
use App\Point;
use Auth;
use Session;
use Notification;

class DiscussionsController extends Controller
{
    public function user_discussions()
    {
        /**
         * SHOWING DISCUSSIONS SPECIFIC TO A USER
         */
        $discussions = Discussion::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')->paginate(4);

        return view('discussions.user-discussions')->with('discussions', $discussions);
    }

    public function create() {
        return view('discussions');
    }

    public function store() {

        $request = request();
        /**
         * VALIDATING USER INPUTS
         */
        $this->validate($request, [
            'title' => 'required',
            'topic_id' => 'required',
            'content' => 'required'
        ]);
        
        /**
         * GETTING THE LAST DISCUSSION ID
         */
        $lastDiscussion = Discussion::orderBy('created_at', 'desc')->first();

        $discussion = Discussion::create([
            'title' => $request->title,
            'content' => $request->content,
            'topic_id' => $request->topic_id,
            'user_id' => Auth::id(),
            'slug' => str_slug($request->title."-".($lastDiscussion->id+1))
        ]);

        Session::flash('success', 'Discussion successfully created');
        
        return redirect()
            ->route('discussions.show', ['slug' => $discussion->slug]);
    }

    public function show($slug) {
        /**
         * SHOWING SINGLE DISCUSSION
         */
        $discussion = Discussion::where('slug', $slug)->first();
        $best_answer = $discussion->replies()->where('best_answer', 1)->first();
        $point = Point::where('user_id', $discussion->user_id)->first();
        return view('discussions.show')
            ->with('discussion', $discussion)
            ->with('point', $point)
            ->with('best_answer', $best_answer);
    }

    public function edit($id) {
        $discussion = Discussion::find($id);
        /**
         * PROTECTING THE ROUTE FOR ENSURING ONLY 
         * THE USER WHO CREATED THE DISCUSSION CAN EDIT.
         */
        if ($discussion->user_id !== Auth::id()) {
            return redirect()->back();
        }

        $topics = Topic::all();
        return view('discussions.edit')
            ->with('discussion', $discussion)->with('topics', $topics);
    }

    public function update(Request $request, $id) {
        $discussion = Discussion::find($id); 
        /**
         * PROTECTING THE ROUTE FOR ENSURING ONLY 
         * THE USER WHO CREATED THE DISCUSSION CAN UPDATE.
         */
        if ($discussion->user_id !== Auth::id()) {
            return redirect()->back();
        }

        $discussion->title = $request->title;
        $discussion->topic_id = $request->topic_id;
        $discussion->content = $request->content; 

        $discussion->save();
        return redirect()->route('discussions.show', ['slug' => $discussion->slug]);
    }

    public function destroy($id) {
        Discussion::destroy($id);
        /**
         * PROTECTING THE ROUTE FOR ENSURING ONLY 
         * THE USER WHO CREATED THE DISCUSSION CAN DELETE.
         */
        if ($discussion->user_id !== Auth::id()) {
            return redirect()->back();
        }

        Session::flash('success', 'Discussion has been deleted');
        return redirect()->back();
    }

    public function reply(Request $request, $id)
    {
        $discussion = Discussion::find($id);
        $watchers = array();
        /**
         * VALIDATING REPLY
         */
        $this->validate($request, [
            'content' => 'required'
        ]);

        $reply = Reply::create([
            'user_id' => Auth::id(),
            'discussion_id' => $id,
            'content' => request()->content
        ]);

        foreach ($discussion->watchers as $watcher) {
            array_push($watchers, User::find($watcher->user_id));
        }
        /**
         * SENDING EMAIL NOTIFICATION TO THE 
         * USERS WHO ARE FOLLOWING THE DISCUSSION
         * WHENEVER SOMEONE LEAVES A REPLY
         */
        Notification::send($watchers, new \App\Notifications\NewReplyAdded($discussion));

        Session::flash('success', 'Replied to discussion');
        return redirect()->back();
    }
}
