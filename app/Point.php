<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Point extends Model
{
    protected $fillable = ['user_id', 'point'];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
