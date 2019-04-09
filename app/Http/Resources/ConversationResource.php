<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
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
            'parent_id' => $this->parent_id,
            'body' => $this->body,
            'created_at_human' => $this->created_at ? $this->created_at->diffForHumans() : null,
            'last_reply_human' => $this->last_reply ? $this->last_reply->diffForHumans() : null,
            'participant_count' => $this->usersExceptCurrentlyAuthenticated->count(),
            'replies' => ConversationResource::collection($this->replies),
            'user' => new UserResource($this->user),
            'users' => UserResource::collection($this->users),
        ];
    }
}
