<?php

namespace App\Http\Controllers\API;

use App\Events\ConversationReplyCreated;
use App\Http\Resources\ConversationReplyResource;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConversationReplyController extends Controller
{
    public function store(Request $request, Conversation $conversation){
        $this->validate($request, [
            'body' => 'required|max:3000'
        ]);

        $this->authorize('reply', $conversation);

        $reply = new Conversation();
        $reply->body = $request->body;
        $reply->user()->associate($request->user());

        $conversation->replies()->save($reply);

        $conversation->touchLastReply();

        broadcast(new ConversationReplyCreated($reply))->toOthers();

        return new ConversationResource($reply);
    }
}
