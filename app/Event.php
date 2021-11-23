<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'date',
    ];

    protected $hidden = [
        'organizer_id',
    ];

    public function getNumRegistrations()
    {
        return Registration::whereIn('ticket_id', EventTicket::where('event_id', $this->id)->get()->pluck('id'))->count();
    }

    public function getFormattedDate()
    {
        return Carbon::parse($this->date)->format('F j, Y');
    }

    public function getSessions() {
        if (isset($this->session_cache)) {
            return $this->session_cache;
        }

        $this->session_cache = Session::select('sessions.*')
            ->join('rooms', 'sessions.room_id', '=', 'rooms.id')
            ->join('channels', 'rooms.channel_id', '=', 'channels.id')
            ->where('channels.event_id', $this->id)
            ->orderBy('sessions.start', 'asc')
            ->get();

        return $this->session_cache;
    }

    public function getRegistrations()
    {
        return Registration::whereIn('ticket_id', $this->tickets->pluck('id'))->get();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function channels()
    {
        return $this->hasMany('App\Channel');
    }

    public function tickets()
    {
        return $this->hasMany('App\EventTicket');
    }

    public function organizer()
    {
        return $this->belongsTo('App\Organizer');
    }

    public function rooms()
    {
        return $this->hasManyThrough('App\Room', 'App\Channel');
    }
}
