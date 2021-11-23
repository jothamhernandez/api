<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Session extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'speaker',
        'start',
        'end',
        'cost',
        'type',
    ];

    protected $casts = [
        'cost' => 'double',
    ];

    protected $hidden = [
        'room_id',
    ];

    public function getFormattedStart(bool $full = false)
    {
        return Carbon::parse($this->start)->format(($full ? 'Y-m-d ' : '').'H:i');
    }

    public function getFormattedEnd(bool $full = false)
    {
        return Carbon::parse($this->end)->format(($full ? 'Y-m-d ' : '').'H:i');
    }

    public function getNumAttendees()
    {
        if ($this->type === 'talk') {
            return $this->room->channel->event->getRegistrations()->count();
        } else {
            return SessionRegistration::where('session_id', $this->id)->count();
        }
    }

    public function room()
    {
        return $this->belongsTo('App\Room');
    }
}
