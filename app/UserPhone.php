<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPhone extends Model
{
    protected $table = 'users_phones';

    protected $guarded = ['id'];

    public function diallingCode($id){
        return DiallingCode::find($id)->first();
    }
}
