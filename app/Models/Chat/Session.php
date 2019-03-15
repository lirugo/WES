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

    public function blockChat(){
        $this->update([
            'block' => true,
            'blocked_by' => auth()->id(),
        ]);
    }

    public function unBlockChat(){
        $this->update([
            'block' => false,
            'blocked_by' => null,
        ]);
    }
}
