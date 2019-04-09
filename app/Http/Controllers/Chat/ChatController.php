<?php

namespace App\Http\Controllers\Chat;

use App\Http\Resources\UserResource;
use App\Models\Conversation\Conversation;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function index(){
        return view('chat.index');
    }

    public function conversations(){
        $team = Auth::user()->teams()->first();
        return view('chat.conversations')
            ->withUsers(UserResource::collection($team->getMembers()));
    }

    public function show(Conversation $conversation){
        $this->authorize('show', $conversation);
        $team = Auth::user()->teams()->first();
        return view('chat.conversations')
            ->withConversation($conversation)
            ->withUsers(UserResource::collection($team->getMembers()));
    }
}
