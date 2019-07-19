<?php

namespace App\Http\Controllers\Chat;

use App\Http\Resources\UserResource;
use App\Models\Conversation\Conversation;
use Auth;
use Session;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function index(){
        //Hide chat page
        Session::flash('warning', 'Chat closed on development');
        return back();
//        return view('chat.index');
    }

    public function conversations(){
        //Hide chat page
        Session::flash('warning', 'Chat closed on development');
        return back();

//        $team = Auth::user()->teams()->first();
//        if($team)
//            $users = UserResource::collection($team->getMembers());
//        else
//            $users = null;
//        return view('chat.conversations')
//            ->withUsers($users);
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
