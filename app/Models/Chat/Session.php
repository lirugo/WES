<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $guarded = ['id'];

    public function chats(){
        return $this->hasManyThrough(Chat::class, Message::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function deleteChats(){
        $this->chats()->where('user_id', auth()->id())->delete();
    }

    public function deleteMessages(){
        $this->messages()->delete();
    }
}