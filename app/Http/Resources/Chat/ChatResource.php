<?php

namespace App\Http\Resources\Chat;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'message' => $this->message['content'],
            'type' => $this->type,
            'read_at' => $this->readAtTime($this),
            'send_at' => $this->created_at->diffForHumans(),
        ];
    }

    private function readAtTime($_this){
        $readAt = $_this->type == 0 ? $_this->read_at : null;

        return $readAt ? $readAt->diffForHumans() : null;
    }
}
