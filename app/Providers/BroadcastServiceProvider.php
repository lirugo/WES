<?php

namespace App\Providers;

use App\Models\Chat\Session;
use App\Models\Conversation\Conversation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        //Conversations Chat #2
        Broadcast::channel('user.{id}', function ($user, $id) {
            return (int) $user->id === (int) $id;
        });
        Broadcast::channel('conversation.{id}', function ($user, $conversationId) {
            return $user->isInConversation(Conversation::find($conversationId));
        });


        //OLD CHAT
        Broadcast::channel('App.User.{id}', function ($user, $id) {
            return (int) $user->id === (int) $id;
        });

        Broadcast::channel('Chat', function ($user) {
            return $user;
        });

        Broadcast::channel('Chat.{session}', function ($user, Session $session) {
            if($user->id == $session->user1_id || $user->id == $session->user2_id)
                return true;
            else
                return false;
        });

    }

}
