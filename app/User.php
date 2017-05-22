<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'privilege'
    ];

    public function isAdmin()
    {
        return $this->privilege === "ADMINISTRATOR";
    }

    public function isManager()
    {
        return $this->privilege === "MANAGER";
    }

    public function isClerk()
    {
        return $this->privilege === "CLERK";
    }

    public function items()
    {
        return $this->hasMany("App\Items");
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
