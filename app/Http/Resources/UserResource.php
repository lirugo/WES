<?php

namespace App\Http\Resources;

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
        $middle_name = is_null($this->name->middle_name) ? '' : ' '.$this->name->middle_name;
        return [
            'id' => $this->id,
            'name' => $this->getShortName(),
            'full_name' => $this->name->second_name.' '.$this->name->name.$middle_name,
            'avatar' => $this->avatar,
        ];
    }
}
