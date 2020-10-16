<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'name' => $this->getFullName(),
            'avatar' => $this->avatar,

            'email' => $this->email,
            'phone' => $this->getPhone(),
            'age' => Carbon::parse($this->date_of_birth)->age,

            'company' => count($this->jobs) > 0 != "" ? $this->jobs[0]->name : '',
            'position' => count($this->jobs) > 0 ? $this->jobs[0]->position : '',
            'experience' => count($this->jobs) > 0 ? $this->jobs[0]->experience : '',
            'education' => count($this->educations) > 0 ? $this->educations[0] : '',
            'english_lvl' => $this->student != null ? $this->student->english_lvl : '',
            'introductory_score' => $this->student != null ? $this->student->introductory_score : '',
        ];
    }
}
