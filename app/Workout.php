<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $table = 'workout';

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
