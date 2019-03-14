<?php

namespace App\Http\Resources\Chat;

use App\Models\Chat\Session;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->getShortName(),
            'email' => $this->email,
            'phone' => $this->getPhone(),
            'online' => false,
            'session' => $this->sessionDetails()
        ];
    }

    private function sessionDetails(){
        $session = Session::whereIn('user1_id', [auth()->id(), $this->id])->whereIn('user2_id', [auth()->id(), $this->id])->first();
        return new SessionResource($session);
    }
}
