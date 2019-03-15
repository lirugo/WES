<?php

namespace App\Models\Chat;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'read_at' => 'datetime'
    ];

    public function message(){
        return $this->belongsTo(Message::class);
    }

    public function markAsRead(){
        return $this->update(['read_at' => Carbon::now()]);
    }
}
