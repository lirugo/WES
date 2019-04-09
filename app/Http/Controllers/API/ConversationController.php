<?php

namespace App\Http\Controllers\API;

use App\Events\ConversationCreated;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation\Conversation;
use Auth;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request){
        $conversations = Auth::user()->conversations()->orderByDesc('id')->get();

        return ConversationResource::collection($conversations);
    }

    public function show(Conversation $conversation){
        $this->authorize('show', $conversation);

        if($conversation->isReply())
            abort(404);

        return new ConversationResource($conversation);
    }

    public function store(Request $request){

        //validate
        $this->validate($request, [
            'body' => 'required|max:3000',
            'recipients' => 'required|array|exists:users,id',
        ]);

        $conversation = new Conversation();
        $conversation->body = $request->body;
        $conversation->user()->associate($request->user());
        $conversation->save();
        $conversation->touchLastReply();

        $conversation->users()->sync(array_unique(
                array_merge($request->recipients, [$request->user()->id])
        ));

        $conversation->load('users');

        broadcast(new ConversationCreated($conversation))->toOthers();

        return new ConversationResource($conversation);
    }
}
