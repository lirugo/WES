@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('user-profile') }}
@endsection
@section('content')
    <div class="row m-b-0">
        <div class="col s12 m8">
            <div class="card-panel small hoverable">
                <h5 class="m-t-0 m-b-20 center-align">Social networks</h5>
                <div class="row m-b-0">
                    @foreach(Auth::user()->socials as $social)
                        <div class="col s4 xl3">
                            {!! Form::open(['route' => ['social.delete', $social->id]]) !!}
                            <div class="valign-wrapper">
                                <a href="{{$social->url}}">{{$social->name}}</a>
                                <button type="submit" class=" transparent border-none"><i class="material-icons icon-red">delete</i></button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    @endforeach
                    @if(count(Auth::user()->socials) == 0)
                        <h6 class="center">Not have any social links.</h6>
                    @endif
                </div>
                <div class="row m-b-0">
                    {!! Form::open(['route' => ['social.store', Auth::user()->id], 'method' => 'POST']) !!}
                    <div class="input-field col s3">
                        <select name="name" required>
                            <option value="" disabled>Select social</option>
                            @foreach (config('social.name') as $key => $name)
                                <option value="{{ $key }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field col s6">
                        <input id="url" type="text" name="url" class="validate" required>
                        <label for="url">URL</label>
                    </div>
                    <div class="input-field col s3">
                        <button class="btn waves-effect waves-light green" type="submit">Add
                            <i class="material-icons right">add</i>
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            {{--<div class="card hoverable" id="avatar">--}}
                {{--<div class="card-image">--}}
                    {{--<img src="{{asset('/uploads/avatars/'.$user->avatar)}}">--}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="card hoverable" id="avatar">
                <div class="card-image">
                    <img :src="imgDataUrl" id="avatarFile">
                    <a class="btn-floating btn-large halfway-fab waves-effect waves-light red" @click="toggleShow"><i class="material-icons">cloud_upload</i></a>
                </div>
                <input name="avatar" type="hidden" v-model="avatarName"/>
                <widget-avatar-cropper
                        field="avatar"
                        @crop-success="cropSuccess"
                        @crop-upload-success="cropUploadSuccess"
                        @crop-upload-fail="cropUploadFail"
                        v-model="show"
                        :width="900"
                        :height="900"
                        lang-type='en'
                        no-rotate
                        url="/store/avatar"
                        :params="params"
                        :headers="headers"
                        img-format="png">
                </widget-avatar-cropper>
            </div>
        </div>
    </div>
    {!! Form::open(['route' => 'user.profile.update', 'method' => 'POST']) !!}
    {{--Name and General block--}}
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">Name</h5>
                @foreach($user->names as $name)
                    <blockquote>
                        {{strtoupper($name->language)}} language
                    </blockquote>
                    <div class="input-field">
                        {!! Form::text('second_name_'.$name->language, $name->second_name, ['class' => 'validate', 'id' => 'second_name_'.$name->language, 'required']) !!}
                        <label for="second_name_{{$name->language}}">Second Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('name_'.$name->language, $name->name, ['class' => 'validate', 'id' => 'name_'.$name->language, 'required']) !!}
                        <label for="name_{{$name->language}}">Name</label>
                    </div>
                    @if($name->language != 'en')
                    <div class="input-field">
                        {!! Form::text('middle_name_'.$name->language, $name->middle_name, ['class' => 'validate', 'id' => 'middle_name_'.$name->language, 'required']) !!}
                        <label for="middle_name_{{$name->language}}">Middle Name</label>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">General</h5>
                {{--Date of birth--}}
                <div class="input-field">
                    <i class="material-icons prefix">date_range</i>
                    {!! Form::text('date_of_birth', $user->date_of_birth, ['class' => 'validate datepicker', 'id' => 'date_of_birth', 'required']) !!}
                    <label for="date_of_birth">Date of Birthday {{'('.$user->getCountOfYear().' years)'}}</label>
                    <span class="helper-text" data-error="wrong" data-success="All is Ok."></span>
                </div>
                {{--Email--}}
                <div class="input-field">
                    <i class="material-icons prefix">email</i>
                    {!! Form::email('email', $user->email, ['class' => 'validate', 'id' => 'email', 'disabled']) !!}
                    <label for="email">Email</label>
                    <span class="helper-text" data-error="wrong" data-success="All is Ok.">example@domain.com</span>
                </div>
                <div class="row m-b-0 m-t-0">
                    <div class="col s4">
                        {{--Dialing code--}}
                        <div class="input-field m-b-0 m-t-0">
                            <i class="material-icons prefix">phone</i>
                            <select name="dialling_code">
                                <option value="" disabled>Country Code</option>
                                @foreach (config('dialling_code') as $key => $name)
                                    <option value="{{ $key }}"{{ Auth::user()->phones()->first()->getCode()->dialling_code == $key ? 'selected="selected"' : '' }}>{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col s8">
                        {{--User phone--}}
                        <div class="input-field m-b-0 m-t-0">
                            {!! Form::text('phone_number', Auth::user()->phones()->first()->phone_number, ['class' => 'validate', 'id' => 'phone_number', 'required']) !!}
                        </div>
                    </div>
                </div>
                {{--Gender--}}
                <div class="input-field">
                    <i class="material-icons prefix">accessibility</i>
                    {!! Form::text('gender', ucfirst($user->gender), ['class' => 'validate', 'id' => 'gender', 'disabled']) !!}
                    <span class="helper-text" data-error="wrong" data-success="All is Ok.">Gender</span>
                </div>
                {{--Student--}}
                @if($user->hasRole('student'))
                    <div class="row m-b-0">
                        <div class="col s12 m4 l4">
                            {{--English lvl--}}
                            <div class="input-field">
                                <i class="material-icons prefix">language</i>
                                {!! Form::text('english_lvl', $user->student->english_lvl, ['class' => 'validate', 'id' => 'gender', 'disabled']) !!}
                                <label for="english_lvl">1(min) to 5(max)</label>
                                <span class="helper-text" data-error="wrong" data-success="All is Ok.">English level</span>
                            </div>
                        </div>
                        <div class="col s12 m4 l4">
                            {{--Introduction score--}}
                            <div class="input-field">
                                <i class="material-icons prefix">dvr</i>
                                {!! Form::text('introductory_score', $user->student->introductory_score, ['class' => 'validate', 'id' => 'gender', 'disabled']) !!}
                                <span class="helper-text" data-error="Choose a rating from 50 to 100" data-success="All is Ok">Introductory score</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{--Education and Job block--}}
    <div class="row">
        @foreach($user->educations as $education)
            <div class="col s12 m6 l6">
                <div class="card-panel hoverable">
                    <h5 class="m-t-0 center-align">Education</h5>
                    <div class="input-field">
                        {!! Form::text('education_name', $education->name, ['class' => 'validate', 'id' => 'education_name', 'required']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Name of the educational institution</span>
                    </div>
                    <div class="input-field">
                        {!! Form::text('education_speciality', $education->speciality, ['class' => 'validate', 'id' => 'education_speciality', 'required']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Name of speciality</span>
                    </div>
                    <div class="input-field">
                        <select name="education_rank">
                            <option value="" disabled>Education Rank</option>
                            @foreach (config('education_rank') as $key => $name)
                                <option value="{{ $name }}"{{ $education->rank == $key ? 'selected="selected"' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Degree</span>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($user->jobs as $job)
            <div class="col s12 m6 l6">
                <div class="card-panel hoverable">
                    <h5 class="m-t-0 center-align">Job</h5>
                    <div class="input-field">
                        {!! Form::text('job_name', $job->name, ['class' => 'validate', 'id' => 'job_name', 'required']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Name of organisation</span>
                    </div>
                    <div class="input-field">
                        {!! Form::text('job_position', $job->position, ['class' => 'validate', 'id' => 'job_speciality', 'required']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Name of position</span>
                    </div>
                    <div class="input-field">
                        {!! Form::number('job_experience', $job->experience, ['class' => 'validate', 'id' => 'job_experience', 'min' => 1, 'max' => 50, 'step' => 1, 'required']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Managerial experience, years</span>
                    </div>
                    <p>
                        <label>
                            <input type="checkbox" name="current_job" {{$job->current_job ? "checked=\"true\"" : ""}} />
                            <span>This is my current job</span>
                        </label>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <button type="submit" class="btn-floating btn-large green tooltipped" data-position="left" data-tooltip="Update Profile">
            <i class="large material-icons">save</i>
        </button>
    </div>
    {!! Form::close() !!}
@endsection
@section('scripts')
    {{--Avatar widget--}}
    <script>
        new Vue({
            el: '#avatar',
            data: {
                show: false,
                params: {
                    name: 'avatar',
                },
                headers: {
                    'X-CSRF-Token': document.head.querySelector("[name=csrf-token]").content
                },
                imgDataUrl: '/uploads/avatars/{!! $user->avatar !!}',
                avatarName: ''
            },
            methods: {
                toggleShow() {
                    this.show = !this.show;
                },
                /**
                 * crop success
                 *
                 * [param] imgDataUrl
                 * [param] field
                 */
                cropSuccess(imgDataUrl, field){
                    console.log('-------- crop success --------');
                    this.imgDataUrl = imgDataUrl;
                },
                /**
                 * upload success
                 *
                 * [param] jsonData  server api return data, already json encode
                 * [param] field
                 */
                cropUploadSuccess(jsonData, field){
                    this.avatarName = jsonData.avatar;
                    axios.post('/user/profile/setAvatar', {'avatar': this.avatarName})
                        .then(response => {
                            console.log('-------- upload success --------');
                        })
                        .catch(e => {
                            this.errors.push(e)
                        })
                },
                /**
                 * upload fail
                 *
                 * [param] status    server api return error status, like 500
                 * [param] field
                 */
                cropUploadFail(status, field){
                    console.log('-------- upload fail --------');
                    console.log(status);
                    console.log('field: ' + field);
                }
            }
        });
    </script>
    {{--Password reset--}}
    <script>

    </script>
@endsection
