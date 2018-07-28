<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use MongoDB\Driver\Exception\Exception;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'date_of_birth', 'english_lvl', 'introductory_score', 'avatar', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function names()
    {
        return $this->hasMany(UserName::class);
    }

    public function phones()
    {
        return $this->hasMany(UserPhone::class);
    }

    public function educations()
    {
        return $this->hasMany(UserEducation::class);
    }

    public function jobs()
    {
        return $this->hasMany(UserJob::class);
    }

    public function socials()
    {
        return $this->hasMany(UserSocial::class);
    }

    public function storeStudent($request){
        $user = $this->create([
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'english_lvl' => $request->english_lvl,
            'introductory_score' => $request->introductory_score,
            'avatar' => $request->avatar,
            'gender' => $request->gender,
            'password' => bcrypt($request->gender),
        ]);

        $name_ua = new UserName([
            'user_id' => $user->id,
            'language' => 'ua',
            'second_name' => $request->second_name_ua,
            'name' => $request->name_ua,
            'middle_name' => $request->middle_name_ua,
        ]);
        $name_ru = new UserName([
            'user_id' => $user->id,
            'language' => 'ru',
            'second_name' => $request->second_name_ru,
            'name' => $request->name_ru,
            'middle_name' => $request->middle_name_ru,
        ]);
        $name_en = new UserName([
            'user_id' => $user->id,
            'language' => 'en',
            'second_name' => $request->second_name_en,
            'name' => $request->name_en,
            'middle_name' => $request->middle_name_en,
        ]);
        $phone = new UserPhone([
            'user_id' => $user->id,
            'dialling_code_id' => DiallingCode::where('dialling_code', '=', $request->dialling_code)->first()->id,
            'phone_number' => $request->phone_number,
        ]);
        $education = new UserEducation([
            'user_id' => $user->id,
            'name' => $request->education_name,
            'speciality' => $request->education_speciality,
            'rank' => $request->education_rank,
        ]);
        $job = new UserJob([
            'user_id' => $user->id,
            'name' => $request->job_name,
            'position' => $request->job_position,
            'experience' => $request->job_experience,
            'current_job' => $request->current_job == null ? false : true,
        ]);
        if($request->social_facebook)
            $facebook = new UserSocial([
                'user_id' => $user->id,
                'name' => 'FaceBook',
                'url' => $request->social_facebook,
            ]);
        if($request->social_twitter)
            $twitter = new UserSocial([
                'user_id' => $user->id,
                'name' => 'Twitter',
                'url' => $request->social_twitter,
            ]);
        if($request->social_linkedin)
            $linkedin = new UserSocial([
                'user_id' => $user->id,
                'name' => 'LinkedIn',
                'url' => $request->social_linkedin,
            ]);

        try {
            $user->names()->save($name_ua);
            $user->names()->save($name_ru);
            $user->names()->save($name_en);
            $user->phones()->save($phone);
            $user->educations()->save($education);
            $user->jobs()->save($job);
            if(isset($facebook))
            $user->socials()->save($facebook);
            if(isset($twitter))
            $user->socials()->save($twitter);
            if(isset($linkedin))
            $user->socials()->save($linkedin);
        }catch (Exception $e){
            $user->delete();
            return false;
        }

        return true;
    }

    public function addName($userId, $lang, $secondName, $name, $middleName){
        return UserName::create([
            'user_id' => $userId,
            'language' => $lang,
            'second_name' => $secondName,
            'name' => $name,
            'middle_name' => $middleName,
        ]);
    }
}
