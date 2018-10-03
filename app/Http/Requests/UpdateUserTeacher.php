<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserTeacher extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'second_name_ua' => 'max:50',
            'name_ua' => 'max:50',
            'middle_name_ua' => 'max:50',
            'second_name_ru' => 'max:50',
            'name_ru' => 'max:50',
            'middle_name_ru' => 'max:50',
            'second_name_en' => 'max:50',
            'name_en' => 'max:50',
            'middle_name_en' => 'max:50',

            'science_degree' => 'string',
            'academic_status' => 'string',
            'teacher_status' => '|in:' . implode(',', array_keys(config('teacher_status'))),

            'education_name' => 'string',
            'education_speciality' => 'string',
            'education_rank' => '|in:' . implode(',', array_keys(config('education_rank'))),

            'job_name' => 'string',
            'job_position' => 'string',
            'job_experience' => 'numeric',

            'social_facebook' => 'nullable|active_url',
            'social_twitter' => 'nullable|active_url',
            'social_linkedin' => 'nullable|active_url',
        ];
    }
}
