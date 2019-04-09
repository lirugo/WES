<?php

namespace App\Http\Resources;

use App\Models\Conversation\Conversation;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationReplyResource extends JsonResource
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
            'created_at_human' => $this->created_at->diffForHumans(),
            'last_reply_human' => $this->last_reply ? $this->last_reply->diffForHumans() : null,
            'user' => new UserResource($this->user),
            'parent_user' => $this->parent_id != null ? Conversation::find($this->parent_id)->user() : null,
            'parent_users' => $this->parent_id != null ? Conversation::find($this->parent_id)->users() : null,
        ];
    }
}
