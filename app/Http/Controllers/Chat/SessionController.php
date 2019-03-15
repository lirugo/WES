<?php

namespace App\Http\Controllers\Chat;

use App\Events\SessionEvent;
use App\Http\Resources\Chat\SessionResource;
use App\Models\Chat\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionController extends Controller
{
    public function store(Request $request){

        $session = Session::create([
            'user1_id' => auth()->id(),
            'user2_id' => $request->friendId,
        ]);

        $sessionResource = new SessionResource($session);

        broadcast(new SessionEvent($sessionResource, auth()->id()));

        return $sessionResource;
    }
}
