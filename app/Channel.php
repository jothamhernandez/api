<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'event_id',
    ];

    public function rooms()
    {
        return $this->hasMany('App\Room');
    }

    public function sessions()
    {
        return $this->hasManyThrough('App\Session', 'App\Room');
    }

    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
