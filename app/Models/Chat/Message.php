<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = ['id'];

    public function chats(){
        return $this->hasMany(Chat::class);
    }

    public function createForSend($sessionId){
        return $this->chats()->create([
            'session_id' => $sessionId,
            'type' => 0,
            'user_id' => auth()->id(),
        ]);
    }

    public function createForReceive($sessionId, $toUser){
        return $this->chats()->create([
            'session_id' => $sessionId,
            'type' => 1,
            'user_id' => $toUser,
        ]);
    }
}
