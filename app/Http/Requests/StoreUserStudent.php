<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserStudent extends FormRequest
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
            'second_name_ua' => 'required|max:50',
            'name_ua' => 'required|max:50',
            'middle_name_ua' => 'required|max:50',
            'second_name_ru' => 'required|max:50',
            'name_ru' => 'required|max:50',
            'middle_name_ru' => 'required|max:50',
            'second_name_en' => 'required|max:50',
            'name_en' => 'required|max:50',
            'middle_name_en' => 'required|max:50',

            'date_of_birth' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'dialling_code' => 'required|in:' . implode(',', array_keys(config('dialling_code'))),
            'phone_number' => 'required|numeric',
            'gender' => 'required|in:male,female',
            'password' => 'required|min:8|confirmed',

            'english_lvl' => 'required|numeric',
            'introductory_score' => 'required|numeric',

            'education_name' => 'required|string',
            'education_speciality' => 'required|string',
            'education_rank' => 'required||in:' . implode(',', array_keys(config('education_rank'))),

            'job_name' => 'required|string',
            'job_position' => 'required|string',
            'job_experience' => 'required|numeric',

            'social_facebook' => 'nullable|active_url',
            'social_twitter' => 'nullable|active_url',
            'social_linkedin' => 'nullable|active_url',
        ];
    }
}
