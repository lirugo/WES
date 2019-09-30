<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentApiResource extends JsonResource
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
            'dateOfBirth' => $this->date_of_birth,
            'phone' => $this->getPhone(),
            'email' => $this->email,
            'avatar' => $this->avatar,
            'company' => count($this->jobs) > 0 != "" ? $this->jobs[0]->name : '',
            'position' => count($this->jobs) > 0 ? $this->jobs[0]->position : '',
            'experience' => count($this->jobs) > 0 ? $this->jobs[0]->experience : '',
        ];
    }
}
