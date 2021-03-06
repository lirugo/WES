<?php

namespace App;

use App\Models\Conversation\Conversation;
use App\Models\Team\PretestUserAnswer;
use Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Image;
use Laratrust\Traits\LaratrustUserTrait;
use MongoDB\Driver\Exception\Exception;
use function MongoDB\BSON\toJSON;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
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

    public function name(){
        return $this->hasOne(UserName::class)->where('language', Auth::user() ? Auth::user()->language : 'en');
    }

    public function getShortName(){
        $name = $this->names()->where('language', '=', Auth::user() ? Auth::user()->language : 'en')->first();
        if(is_null($name->middle_name))
            return $name->second_name.' '.mb_substr($name->name,0,1).'.';
        else
            return $name->second_name.' '.mb_substr($name->name,0,1).'. '.mb_substr($name->middle_name,0,1).'.';
    }

    public function getFullName(){
        $name = $this->names()->where('language', '=',Auth::user() ? Auth::user()->language : 'en')->first();
        if(is_null($name->middle_name))
            return $name->second_name.' '.$name->name;
        else
            return $name->second_name.' '.$name->name.' '.$name->middle_name;
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

    public function disciplines()
    {
        return $this->hasMany(UserDiscipline::class);
    }

    public function getTeacherDiscipline($teamName){
        $team = Team::where('name', $teamName)->first();

        foreach ($team->disciplines as $key => $discipline)
            if($discipline->teacher_id != Auth::user()->id)
                $team->disciplines->forget($key);

        return $team->disciplines;
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

    public function storeTeacher($request){
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
        $teacher = new UserTeacher([
            'user_id' => $user->id,
            'science_degree' => $request->science_degree,
            'academic_status' => $request->academic_status,
            'teacher_status' => $request->teacher_status,
            'can_teach_in_english' => $request->can_teach_in_english == null ? false : true,
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
            $user->teacher()->save($teacher);
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

    public function storeStudent($request){
        $user = $this->create([
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'password' => bcrypt($request->password),
        ]);

        $user->number_of_contract =  $request->number_of_contract;
        $user->save();

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
            Image::make($avatar)->save( public_path('/uploads/avatars/' . $filename ) );
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

    public function storeTopManager($request){
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
            Image::make($avatar)->save( public_path('/uploads/avatars/' . $filename ) );
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

    public function updateStudent($request){
        $oldData = (object) [];
        $oldData->attributes = $this->attributes;
        $oldData->student = $this->student->attributes;
        $oldData->educations = $this->educations->first()->attributes;
        $oldData->jobs = $this->jobs->first()->attributes;
        $oldData->phones = $this->phones->first()->attributes;
        $oldData->names = $this->names;
        //Save history
        $old = array();
        $new = array();

        //names
        if($this->names->where('language', '=', 'ua')->first()->second_name != $request->second_name_ua){
            $old["second_name_ua"] = $this->names->where('language', '=', 'ua')->first()->second_name;
            $new["second_name_ua"] = $request->second_name_ua;
        }
        if($this->names->where('language', '=', 'ua')->first()->name != $request->name_ua){
            $old["name_ua"] = $this->names->where('language', '=', 'ua')->first()->name;
            $new["name_ua"] = $request->name_ua;}
        if($this->names->where('language', '=', 'ua')->first()->middle_name != $request->middle_name_ua){
            $old["middle_name_ua"] = $this->names->where('language', '=', 'ua')->first()->middle_name;
            $new["middle_name_ua"] = $request->middle_name_ua;
        }

        if($this->names->where('language', '=', 'ru')->first()->second_name != $request->second_name_ru){
            $old["second_name_ru"] = $this->names->where('language', '=', 'ru')->first()->second_name;
            $new["second_name_ru"] = $request->second_name_ru;
        }
        if($this->names->where('language', '=', 'ru')->first()->name != $request->name_ru){
            $old["name_ru"] = $this->names->where('language', '=', 'ru')->first()->name;
            $new["name_ru"] = $request->name_ru;}
        if($this->names->where('language', '=', 'ru')->first()->middle_name != $request->middle_name_ru){
            $old["middle_name_ru"] = $this->names->where('language', '=', 'ru')->first()->middle_name;
            $new["middle_name_ru"] = $request->middle_name_ru;
        }

        if($this->names->where('language', '=', 'en')->first()->second_name != $request->second_name_en){
            $old["second_name_en"] = $this->names->where('language', '=', 'en')->first()->second_name;
            $new["second_name_en"] = $request->second_name_en;
        }
        if($this->names->where('language', '=', 'en')->first()->name != $request->name_en){
            $old["name_en"] = $this->names->where('language', '=', 'en')->first()->name;
            $new["name_en"] = $request->name_en;}
        if($this->names->where('language', '=', 'en')->first()->middle_name != $request->middle_name_en){
            $old["middle_name_en"] = $this->names->where('language', '=', 'en')->first()->middle_name;
            $new["middle_name_en"] = $request->middle_name_en;
        }
        //Other
        if($this->jobs->first()->experience != $request->job_experience){
            $old["experience"] = $this->jobs->first()->experience;
            $new["experience"] = $request->job_experience;
        }
        if($this->student->english_lvl = $request->english_lvl){
            $old["english_lvl"] = $this->student->english_lvl;
            $new["english_lvl"] = $request->english_lvl;
        }



        $changeLog = new ChangeLog();
        $changeLog->author_id = Auth::user()->id;
        $changeLog->target_id = $request->id;
        $changeLog->title = "Student profile was updated";
        $changeLog->type = "UPDATE_STUDENT";
        $changeLog->target_id = $request->id;
        $changeLogBody = "";

        $this->number_of_contract = $request->number_of_contract;
        $this->date_of_birth = $request->date_of_birth;
        $this->email = $request->email;
        $this->save();
        $this->student->english_lvl = $request->english_lvl;
        $this->student->introductory_score = $request->introductory_score;
        $this->student->save();

        $this->educations->first()->name = $request->education_name;
        $this->educations->first()->speciality = $request->education_speciality;
        $this->educations->first()->rank = $request->education_rank;
        $this->educations->first()->save();

        $this->jobs->first()->name = $request->job_name;
        $this->jobs->first()->position = $request->job_position;
        $this->jobs->first()->experience = $request->job_experience;
        $this->jobs->first()->current_job = $request->current_job == 'on' ? true : false;
        $this->jobs->first()->save();

        $this->phones->first()->phone_number = $request->phone_number;
        $this->phones->first()->dialling_code_id = DiallingCode::where('dialling_code', $request->dialling_code)->first()->id;
        $this->phones->first()->save();

        $this->names->where('language', '=', 'ua')->first()->second_name = $request->second_name_ua;
        $this->names->where('language', '=', 'ua')->first()->name = $request->name_ua;
        $this->names->where('language', '=', 'ua')->first()->middle_name = $request->middle_name_ua;
        $this->names->where('language', '=', 'ua')->first()->save();

        $this->names->where('language', '=', 'ru')->first()->second_name = $request->second_name_ru;
        $this->names->where('language', '=', 'ru')->first()->name = $request->name_ru;
        $this->names->where('language', '=', 'ru')->first()->middle_name = $request->middle_name_ru;
        $this->names->where('language', '=', 'ru')->first()->save();

        $this->names->where('language', '=', 'en')->first()->second_name = $request->second_name_en;
        $this->names->where('language', '=', 'en')->first()->name = $request->name_en;
        $this->names->where('language', '=', 'en')->first()->middle_name = $request->middle_name_en;
        $this->names->where('language', '=', 'en')->first()->save();


        //attributes
        $diff1 = array_diff($oldData->attributes, $this->attributes);
        $diff2 = array_diff($this->attributes, $oldData->attributes);
        $old = array_merge($old, $diff1);
        $new = array_merge($new, $diff2);
        //student
        $diff1 = array_diff($oldData->student, $this->student->attributes);
        $diff2 = array_diff($this->student->attributes, $oldData->student);
        $old = array_merge($old, $diff1);
        $new = array_merge($new, $diff2);
        //educations
        $diff1 = array_diff($oldData->educations, $this->educations->first()->attributes);
        $diff2 = array_diff($this->educations->first()->attributes, $oldData->educations);
        $old = array_merge($old, $diff1);
        $new = array_merge($new, $diff2);
        //jobs
        $diff1 = array_diff($oldData->jobs, $this->jobs->first()->attributes);
        $diff2 = array_diff($this->jobs->first()->attributes, $oldData->jobs);
        $old = array_merge($old, $diff1);
        $new = array_merge($new, $diff2);
        //phones
        $diff1 = array_diff($oldData->phones, $this->phones->first()->attributes);
        $diff2 = array_diff($this->phones->first()->attributes, $oldData->phones);
        $old = array_merge($old, $diff1);
        $new = array_merge($new, $diff2);


        $changeLog->body = "";
        $changeLog->old = json_encode($old);
        $changeLog->new = json_encode($new);
        $changeLog->save();
        return true;
    }

    public function updateProfile($request){
        if($request->date_of_birth) {
            $this->date_of_birth = $request->date_of_birth;
            $this->save();
        }
        $this->gender = $request->gender;
        $this->save();

        if($this->educations()->first()) {
            $this->educations->first()->name = $request->education_name;
            $this->educations->first()->speciality = $request->education_speciality;
            $this->educations->first()->rank = $request->education_rank;
            $this->educations->first()->save();
        }

        if($this->jobs()->first()) {
            $this->jobs->first()->name = $request->job_name;
            $this->jobs->first()->position = $request->job_position;
            $this->jobs->first()->experience = $request->job_experience;
            $this->jobs->first()->current_job = $request->current_job == 'on' ? true : false;
            $this->jobs->first()->save();
        }


        $this->phones->first()->phone_number = $request->phone_number;
        $this->phones->first()->dialling_code_id = DiallingCode::where('dialling_code', $request->dialling_code)->first()->id;
        $this->phones->first()->save();
        if($request->second_name_ua){
            $this->names->where('language', '=', 'ua')->first()->second_name = $request->second_name_ua;
            $this->names->where('language', '=', 'ua')->first()->name = $request->name_ua;
            $this->names->where('language', '=', 'ua')->first()->middle_name = $request->middle_name_ua;
            $this->names->where('language', '=', 'ua')->first()->save();
        }
        if($request->second_name_ru) {
            $this->names->where('language', '=', 'ru')->first()->second_name = $request->second_name_ru;
            $this->names->where('language', '=', 'ru')->first()->name = $request->name_ru;
            $this->names->where('language', '=', 'ru')->first()->middle_name = $request->middle_name_ru;
            $this->names->where('language', '=', 'ru')->first()->save();
        }
        if($request->second_name_en) {
            $this->names->where('language', '=', 'en')->first()->second_name = $request->second_name_en;
            $this->names->where('language', '=', 'en')->first()->name = $request->name_en;
            $this->names->where('language', '=', 'en')->first()->middle_name = $request->middle_name_en;
            $this->names->where('language', '=', 'en')->first()->save();
        }
        return true;
    }

    public function updateTeacher($request){
        $this->teacher->science_degree = $request->science_degree;
        $this->teacher->academic_status = $request->academic_status;
        $this->teacher->teacher_status = $request->teacher_status;
        $this->teacher->can_teach_in_english = $request->can_teach_in_english == 'on' ? true : false;
        $this->teacher->save();

        $this->educations->first()->name = $request->education_name;
        $this->educations->first()->speciality = $request->education_speciality;
        $this->educations->first()->rank = $request->education_rank;
        $this->educations->first()->save();

        $this->jobs->first()->name = $request->job_name;
        $this->jobs->first()->position = $request->job_position;
        $this->jobs->first()->experience = $request->job_experience;
        $this->jobs->first()->current_job = $request->current_job == 'on' ? true : false;
        $this->jobs->first()->save();

        $this->phones->first()->phone_number = $request->phone_number;
        $this->phones->first()->dialling_code_id = DiallingCode::where('dialling_code', $request->dialling_code)->first()->id;
        $this->phones->first()->save();

        $this->names->where('language', '=', 'ua')->first()->second_name = $request->second_name_ua;
        $this->names->where('language', '=', 'ua')->first()->name = $request->name_ua;
        $this->names->where('language', '=', 'ua')->first()->middle_name = $request->middle_name_ua;
        $this->names->where('language', '=', 'ua')->first()->save();

        $this->names->where('language', '=', 'ru')->first()->second_name = $request->second_name_ru;
        $this->names->where('language', '=', 'ru')->first()->name = $request->name_ru;
        $this->names->where('language', '=', 'ru')->first()->middle_name = $request->middle_name_ru;
        $this->names->where('language', '=', 'ru')->first()->save();

        $this->names->where('language', '=', 'en')->first()->second_name = $request->second_name_en;
        $this->names->where('language', '=', 'en')->first()->name = $request->name_en;
        $this->names->where('language', '=', 'en')->first()->middle_name = $request->middle_name_en;
        $this->names->where('language', '=', 'en')->first()->save();

//        dd($this->names()->where('language', '=', 'ua')->first()->name);
        return true;
    }

    public function teams(){
        return $this->rolesTeams;
    }

    public function getCountOfYear(){
        return Carbon::parse($this->date_of_birth)->age;
    }

    public function getAllMyStudents(){
        $teams = $this->teams();
        $students = new Collection();
        foreach ($teams as $team){
            $students = $students->merge($team->getStudents());
        }
        return $students;
    }

    public function pretestAnswers(){
        return $this->hasMany(PretestUserAnswer::class, 'user_id', 'id');
    }

    public function settingNotifications(){
        return $this->hasOne(UserSettingNotification::class);
    }

    public function conversations(){
        return $this->belongsToMany(Conversation::class)->whereNull('parent_id')->orderByDesc('last_reply');
    }

    public function isInConversation(Conversation $conversation){
        return $this->conversations->contains($conversation);
    }
}
