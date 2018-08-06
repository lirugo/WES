<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use MongoDB\Driver\Exception\Exception;
use Image;

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
        'email', 'password', 'date_of_birth', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getShortName(){
        $name = $this->names()->where('language', '=','en')->first();
        return $name->second_name.' '.substr($name->name,0,1).'. '.substr($name->middle_name,0,1).'.';
    }

    public function getPhone(){
        $phone = $this->phones()->first();
        $dialling_code = $phone->diallingCode($phone->dialling_code_id)->dialling_code;
        return $dialling_code.' '.$phone->phone_number;
    }

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

    public function teacher()
    {
        return $this->hasOne(UserTeacher::class);
    }

    public function student()
    {
        return $this->hasOne(UserStudent::class);
    }

    public function socials()
    {
        return $this->hasMany(UserSocial::class);
    }

    public function storeStudent($request){
        $user = $this->create([
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'avatar' => $request->avatar,
            'gender' => $request->gender,
            'password' => bcrypt($request->password),
        ]);

        // Handle the user student of avatar
        if($request->avatar){
            $user->avatar = $request->avatar;
            $user->save();
        }

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
        $student = new UserStudent([
            'user_id' => $user->id,
            'english_lvl' => $request->english_lvl,
            'introductory_score' => $request->introductory_score,
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
            $user->student()->save($student);
            if(isset($facebook))
            $user->socials()->save($facebook);
            if(isset($twitter))
            $user->socials()->save($twitter);
            if(isset($linkedin))
            $user->socials()->save($linkedin);
        }catch (Exception $e){
            $user->delete();
            return null;
        }

        return $user;
    }

    public function storeManager($request){
        $user = $this->create([
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'avatar' => $request->avatar,
            'gender' => $request->gender,
            'password' => bcrypt($request->password),
        ]);

        // Handle the user student of avatar
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/uploads/avatars/' . $filename ) );
            $user->avatar = $filename;
            $user->save();
        }

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
            if(isset($facebook))
                $user->socials()->save($facebook);
            if(isset($twitter))
                $user->socials()->save($twitter);
            if(isset($linkedin))
                $user->socials()->save($linkedin);
        }catch (Exception $e){
            $user->delete();
            return null;
        }

        return $user;
    }

    public function teams(){
        return $this->rolesTeams;
    }
}
