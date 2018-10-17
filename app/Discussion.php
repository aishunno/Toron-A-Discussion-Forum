<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Discussion extends Model
{
    protected $fillable = ['title', 'content', 'user_id', 'topic_id', 'slug'];

    public function topic()
    {
        return $this->belongsTo('App\Topic');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    public function watchers() {
        return $this->hasMany('App\Watcher');
    }

    public function is_being_watched() {
        $watchers_ids = array();

        foreach ($this->watchers as $watcher) {
            array_push($watchers_ids, $watcher->user_id);
        }

        if(in_array(Auth::id(), $watchers_ids)) {
            return true;
        } else {
            return false;
        }
    }
}
