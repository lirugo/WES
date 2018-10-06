@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('student-show', $student) }}
@endsection
@section('content')
    {{--Social block--}}
    <div class="row">
        <div class="col s12 m8">
            <div class="card-panel small hoverable">
                <h5 class="m-t-0 m-b-20 center-align">Social networks</h5>
                <div class="row m-b-0">
                    @foreach($student->socials as $social)
                        <div class="col s4 xl3">
                            @if(Auth::user()->hasRole(['top-manager', 'manager']))
                                {!! Form::open(['route' => ['social.delete', $social->id]]) !!}
                                <div class="valign-wrapper">
                                    <a href="{{$social->url}}">{{$social->name}}</a>
                                    <button type="submit" class=" transparent border-none"><i class="material-icons icon-red">delete</i></button>
                                </div>
                                {!! Form::close() !!}
                            @else
                                <div class="valign-wrapper">
                                    <i class="material-icons prefix">insert_link</i><a href="{{$social->url}}">{{$social->name}}</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    @if(count($student->socials) == 0)
                        <h6 class="center">Not have any social links.</h6>
                    @endif
                </div>
                @if(Auth::user()->hasRole(['top-manager', 'manager']))
                    <div class="row m-b-0">
                        {!! Form::open(['route' => ['social.store', $student->id], 'method' => 'POST']) !!}
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
                @endif
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card hoverable" id="avatar">
                <div class="card-image">
                    <img :src="imgDataUrl">
                    <a class="btn-floating btn-large halfway-fab waves-effect waves-light red" @click="toggleShow"><i class="material-icons">cloud_upload</i></a>
                </div>
                <input name="avatar" type="hidden" v-model="avatarName"/>
                <widget-avatar-cropper
                        field="avatar"
                        @crop-success="cropSuccess"
                        @crop-upload-success="cropUploadSuccess"
                        @crop-upload-fail="cropUploadFail"
                        v-model="show"
                        :width="300"
                        :height="300"
                        lang-type='en'
                        no-rotate
                        url="/avatar/{{$student->id}}/update"
                        :params="params"
                        :headers="headers"
                        img-format="png">
                </widget-avatar-cropper>
            </div>
        </div>
    </div>

    {!! Form::open(['route' => ['student.update', $student->id], 'method' => 'POST']) !!}
    {{--Name and General block--}}
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">Name</h5>
                @foreach($student->names as $name)
                    <small>Language - {{$name->language}}</small>
                    <div class="input-field">
                        {!! Form::text('second_name_'.$name->language, $name->second_name, ['class' => 'validate', 'id' => 'second_name_'.$name->language, 'required']) !!}
                        <label for="second_name_{{$name->language}}">Second Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('name_'.$name->language, $name->name, ['class' => 'validate', 'id' => 'name_'.$name->language, 'required']) !!}
                        <label for="name_{{$name->language}}">Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('middle_name_'.$name->language, $name->middle_name, ['class' => 'validate', 'id' => 'middle_name_'.$name->language]) !!}
                        <label for="middle_name_{{$name->language}}">Middle Name</label>
                    </div>
                    <div class="divider"></div>
                @endforeach
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">General</h5>
                {{--Date of birth--}}
                <div class="input-field">
                    <i class="material-icons prefix">date_range</i>
                    {!! Form::text('date_of_birth', $student->date_of_birth, ['class' => 'validate datepicker', 'id' => 'date_of_birth', 'required', 'disabled']) !!}
                    <label for="date_of_birth">Date of Birthday</label>
                    <span class="helper-text" data-error="wrong" data-success="All is Ok."></span>
                </div>
                {{--Email--}}
                <div class="input-field">
                    <i class="material-icons prefix">email</i>
                    {!! Form::email('email', $student->email, ['class' => 'validate', 'id' => 'email', 'required', 'disabled']) !!}
                    <label for="email">Email</label>
                </div>
                {{--Phone--}}
                <div class="row m-b-0 m-t-0">
                    <div class="col s4">
                        {{--Dialing code--}}
                        <div class="input-field m-b-0 m-t-0">
                            <i class="material-icons prefix">phone</i>
                            <select name="dialling_code">
                                <option value="" disabled>Country Code</option>
                                @foreach (config('dialling_code') as $key => $name)
                                    <option value="{{ $key }}"{{ $student->phones()->first()->getCode()->dialling_code == $key ? 'selected="selected"' : '' }}>{{ $key }}</option>
                                @endforeach
                            </select>
                            <span class="helper-text" data-error="wrong" data-success="All is Ok.">Code</span>
                        </div>
                    </div>
                    <div class="col s8">
                        {{--User phone--}}
                        <div class="input-field m-b-0 m-t-0">
                            {!! Form::text('phone_number', $student->phones()->first()->phone_number, ['class' => 'validate', 'id' => 'phone_number', 'required']) !!}
                            <label for="phone_number">XX XXX XX XX</label>
                            <span class="helper-text" data-error="wrong" data-success="All is Ok.">Phone number</span>
                        </div>
                    </div>
                </div>
                {{--Gender--}}
                <div class="input-field">
                    <i class="material-icons prefix">accessibility</i>
                    <select name="gender" required disabled>
                        <option value="" disabled>{{$student->gender}}</option>
                    </select>
                    <span class="helper-text" data-error="wrong" data-success="All is Ok.">Gender</span>
                </div>
                {{--English lvl--}}
                <div class="input-field">
                    <i class="material-icons prefix">language</i>
                    <select name="english_lvl" required>
                        <option value="" disabled>Choose English lvl</option>
                        <option value="1" {{ $student->student->english_lvl == 1 ? 'selected="selected"' : '' }}>1 (min)</option>
                        <option value="2" {{ $student->student->english_lvl == 2 ? 'selected="selected"' : '' }}>2</option>
                        <option value="3" {{ $student->student->english_lvl == 3 ? 'selected="selected"' : '' }}>3</option>
                        <option value="4" {{ $student->student->english_lvl == 4 ? 'selected="selected"' : '' }}>4</option>
                        <option value="5" {{ $student->student->english_lvl == 5 ? 'selected="selected"' : '' }}>5 (max)</option>
                    </select>
                    <span class="helper-text" data-error="wrong" data-success="All is Ok.">English lvl</span>
                </div>
                {{--Introduction score--}}
                <div class="input-field">
                    <i class="material-icons prefix">dvr</i>
                    {!! Form::number('introductory_score', $student->student->introductory_score, ['class' => 'validate', 'id' => 'introductory_score', 'min' => 50, 'max' => 100, 'step' => 1, 'required']) !!}
                    <span class="helper-text" data-error="Choose a rating from 50 to 100" data-success="All is Ok">Introductory score</span>
                </div>
            </div>
        </div>
    </div>
    {{--Education and Job block--}}
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">Education</h5>
                @foreach($student->educations as $education)
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
                @endforeach
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">Current or last job</h5>
                @foreach($student->jobs as $job)
                    <div class="input-field">
                        {!! Form::text('job_name', $job->name, ['class' => 'validate', 'id' => 'job_name', 'required']) !!}
                        <label for="job_name">Name of organisation</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('job_position', $job->position, ['class' => 'validate', 'id' => 'job_speciality', 'required']) !!}
                        <label for="job_speciality">Name of position</label>
                    </div>
                    <div class="input-field">
                        {!! Form::number('job_experience', $job->experience, ['class' => 'validate', 'id' => 'job_experience', 'min' => 1, 'max' => 50, 'step' => 1, 'required']) !!}
                        <label for="job_experience">Managerial experience, years</label>
                    </div>
                    <p>
                        <label>
                            <input type="checkbox" name="current_job" {{$job->current_job ? "checked" : ""}}/>
                            <span>This is my current job</span>
                        </label>
                    </p>
                @endforeach
            </div>
        </div>
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
                imgDataUrl: '/uploads/avatars/' + {!! json_encode($student->avatar) !!},
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
                    console.log('-------- upload success --------');
                    this.avatarName = jsonData.avatar;
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
@endsection
