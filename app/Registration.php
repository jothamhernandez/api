<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'attendee_id',
        'ticket_id',
        'registration_time',
    ];

    public function ticket()
    {
        return $this->belongsTo('App\EventTicket');
    }

    public function sessions()
    {
        return $this->belongsToMany('App\Session', 'session_registrations');
    }
}
