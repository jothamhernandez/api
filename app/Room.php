<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'capacity',
        'channel_id',
    ];

    protected $hidden = [
        'channel_id',
        'capacity',
    ];

    public function sessions()
    {
        return $this->hasMany('App\Session');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }
}
