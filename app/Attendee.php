<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $hidden = [
        'id',
        'registration_code',
        'login_token',
    ];

    public $timestamps = false;
}
