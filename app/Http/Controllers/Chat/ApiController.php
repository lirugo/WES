<?php

namespace App\Http\Controllers\Chat;

use App\Events\MsgRead;
use App\Events\PrivateChatEvent;
use App\Http\Resources\Chat\ChatResource;
use App\Http\Resources\Chat\UserResource;
use App\Models\Chat\Session;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ApiController extends Controller
{
    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function friends()
    {
        $users = auth()->user()->teams()->first()->getMembers();

        $users = new Collection();
        $users->push(User::find(83));
        $users->push(User::find(49));
        $users->push(User::find(48));
        $users = $users->where('id', '!=', auth()->id());

        return UserResource::collection($users);
    }

    public function messageStore(Session $session, Request $request)
    {
        $message = $session->messages()->create(['content' => $request->message]);

        $chat = $message->createForSend($session->id);

        $message->createForReceive($session->id, $request->toUser);

        broadcast(new PrivateChatEvent($message->content, $chat));

        return response($chat->id, 200);
    }

    public function chats(Session $session)
    {
        return ChatResource::collection($session->chats->where('user_id', auth()->id()));
    }

    public function read(Session $session)
    {
        $chats =  $session->chats->where('read_at', null)->where('type', 0)->where('user_id', '!=', auth()->id());

        foreach ($chats as $chat){
            $chat->markAsRead();

            broadcast(new MsgRead(new ChatResource($chat), $chat->session_id));
        }
    }

    public function clear(Session $session)
    {
        $session->deleteChats();
        $session->chats->count() == 0 ? $session->deleteMessages() : '';
        return response('OK', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
