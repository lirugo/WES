<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function names()
    {
        return $this->hasMany(UserName::class);
    }

    public function addName($userId, $lang, $secondName, $name, $middleName){
        return UserName::create([
            'user_id' => $userId,
            'language' => $lang,
            'second_name' => $secondName,
            'name' => $name,
            'middle_name' => $middleName,
        ]);
    }
}
