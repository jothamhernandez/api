<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EventTicket extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'cost',
    ];

    protected $casts = [
        'cost' => 'double',
    ];

    protected $appends = [
        'available',
        'description',
    ];

    protected $hidden = [
        'event_id',
        'special_validity',
    ];

    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function getAvailableAttribute()
    {
        $validity = $this->getValidityRule();
        if (!$validity) {
            return true;
        }

        if ($validity->type === 'date') {
            return Carbon::parse($validity->date)->isAfter(Carbon::now());
        } else if ($validity->type === 'amount') {
            $numSold = Registration::where('ticket_id', $this->id)->count();
            return $numSold < $validity->amount;
        }

        throw new Exception('Invalid validity rule');
    }

    public function getDescriptionAttribute()
    {
        $validity = $this->getValidityRule();
        if (!$validity) {
            return null;
        }

        if ($validity->type === 'date') {
            return 'Available until ' . Carbon::parse($validity->date)->format('F j, Y');
        } else if ($validity->type === 'amount') {
            return $validity->amount . ' ticket' . ($validity->amount !== 1 ? 's' : '') . ' available';
        }

        throw new Exception('Invalid validity rule');
    }

    private function getValidityRule()
    {
        if (!$this->special_validity) {
            return null;
        }

        return json_decode($this->special_validity);
    }
}
