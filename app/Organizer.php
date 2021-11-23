<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Organizer extends Authenticatable
{
    protected $hidden = [
        'password_hash',
        'email',
    ];

    protected $rememberTokenName = false;

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function events()
    {
        return $this->hasMany('App\Event')->orderBy('date', 'asc');
    }
}
