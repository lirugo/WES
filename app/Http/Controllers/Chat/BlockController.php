<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat\Session;

class BlockController extends Controller
{
    public function block(Session $session)
    {
        $session->blockChat();
        return response('OK', 201);
    }

    public function unBlock(Session $session)
    {
        $session->unBlockChat();
        return response('OK', 201);
    }
}
