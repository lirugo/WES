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
        if($team)
            $users = UserResource::collection($team->getMembers());
        else
            $users = null;
        return view('chat.conversations')
            ->withUsers($users);
    }

    public function show(Conversation $conversation){
        $this->authorize('show', $conversation);
        $team = Auth::user()->teams()->first();
        if($team)
            $users = UserResource::collection($team->getMembers());
        else
            $users = null;
        return view('chat.conversations')
            ->withConversation($conversation)
            ->withUsers($users);
    }
}
