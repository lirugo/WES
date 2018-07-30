@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => 'student.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        {{--Header--}}
        <div class="row">
            <div class="col s12">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">Create a new student</span>
                        <button type="submit" class="indigo waves-effect waves-light btn right tooltipped" data-tooltip="You sure? All data is correct?" data-position="top"><i class="material-icons right">send</i>Create a new user</button>
                        <a href="{{url('/manage')}}" class="indigo waves-effect waves-light btn left m-r-10 tooltipped" data-tooltip="Information will be lost!" data-position="top"><i class="material-icons left">apps</i>Back to manage</a>
                    </div>
                </div>
            </div>
        </div>
        {{--Name and General block--}}
        <div class="row">
            <div class="col s6">
                <div class="card-panel hoverable">
                    <h5 class="m-t-0 center-align">Name</h5>
                    <blockquote>
                        Ukrainian language
                    </blockquote>
                    <div class="input-field">
                        {!! Form::text('second_name_ua', null, ['class' => 'validate', 'id' => 'second_name_ua', 'required']) !!}
                        <label for="second_name_ua">Second Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('name_ua', null, ['class' => 'validate', 'id' => 'name_ua', 'required']) !!}
                        <label for="name_ua">Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('middle_name_ua', null, ['class' => 'validate', 'id' => 'middle_name_ua', 'required']) !!}
                        <label for="middle_name_ua">Middle Name</label>
                    </div>

                    <blockquote>
                        Russian language
                    </blockquote>
                    <div class="input-field">
                        {!! Form::text('second_name_ru', null, ['class' => 'validate', 'id' => 'second_name_ru', 'required']) !!}
                        <label for="second_name_ru">Second Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('name_ru', null, ['class' => 'validate', 'id' => 'name_ru', 'required']) !!}
                        <label for="name_ru">Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('middle_name_ru', null, ['class' => 'validate', 'id' => 'middle_name_ru', 'required']) !!}
                        <label for="middle_name_ru">Middle Name</label>
                    </div>

                    <blockquote>
                        English language
                    </blockquote>
                    <div class="input-field">
                        {!! Form::text('second_name_en', null, ['class' => 'validate', 'id' => 'second_name_en', 'required']) !!}
                        <label for="second_name_en">Second Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('name_en', null, ['class' => 'validate', 'id' => 'name_en', 'required']) !!}
                        <label for="name_en">Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('middle_name_en', null, ['class' => 'validate', 'id' => 'middle_name_en', 'required']) !!}
                        <label for="middle_name_en">Middle Name</label>
                    </div>
                </div>
            </div>
            <div class="col s6">
                <div class="card-panel hoverable">
                    <h5 class="m-t-0 center-align">General</h5>
                    {{--Date of birth--}}
                    <div class="input-field">
                        <i class="material-icons prefix">date_range</i>
                        {!! Form::text('date_of_birth', null, ['class' => 'validate datepicker', 'id' => 'date_of_birth', 'required']) !!}
                        <label for="date_of_birth">Date of Birthday</label>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok."></span>
                    </div>
                    {{--Email--}}
                    <div class="input-field">
                        <i class="material-icons prefix">email</i>
                        {!! Form::email('email', null, ['class' => 'validate', 'id' => 'email', 'required']) !!}
                        <label for="email">Email</label>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">example@domain.com</span>
                    </div>
                    {{--Password--}}
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input id="password" type="password" name="password" class="validate" min="8" required>
                        <label for="password">Password</label>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Minimum 8 characters</span>
                    </div>
                    {{--Password Confirmation--}}
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="validate" min="8" required>
                        <label for="password_confirmation">Password Confirmation</label>
                    </div>
                    {{--Phone--}}
                    <div class="row">
                        <div class="col s4">
                            {{--Dialing code--}}
                            <div class="input-field">
                                <i class="material-icons prefix">phone</i>
                                <select name="dialling_code">
                                    <option value="" disabled>Code</option>
                                    @foreach (config('dialling_code') as $key => $name)
                                        <option value="{{ $key }}"{{ old('dialling_code') === $key ? 'selected="selected"' : '' }}>{{ $key }}</option>
                                    @endforeach
                                </select>
                                <span class="helper-text" data-error="wrong" data-success="All is Ok.">Country code</span>
                            </div>
                        </div>
                        <div class="col s8">
                            {{--User phone--}}
                            <div class="input-field">
                                {!! Form::text('phone_number', null, ['class' => 'validate', 'id' => 'phone_number', 'required']) !!}
                                <label for="phone_number">XX XXX XX XX</label>
                                <span class="helper-text" data-error="wrong" data-success="All is Ok.">Phone number</span>
                            </div>
                        </div>
                    </div>
                    {{--Gender--}}
                    <div class="input-field">
                        <i class="material-icons prefix">accessibility</i>
                        <select name="gender" required>
                            <option value="" disabled>Select gender</option>
                            <option value="male" selected {{ old('gender') ? 'selected="selected"' : '' }}>Male</option>
                            <option value="female" {{ old('gender') ? 'selected="selected"' : '' }}>Female</option>
                        </select>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Select a gender of student</span>
                    </div>
                    {{--English lvl--}}
                    <div class="input-field">
                        <i class="material-icons prefix">language</i>
                        <select name="english_lvl" required>
                            <option value="" disabled>Choose English lvl</option>
                            <option value="1" {{ old('english_lvl') ? 'selected="selected"' : '' }}>1</option>
                            <option value="2" {{ old('english_lvl') ? 'selected="selected"' : '' }}>2</option>
                            <option value="3" {{ old('english_lvl') ? 'selected="selected"' : '' }}>3</option>
                            <option value="4" {{ old('english_lvl') ? 'selected="selected"' : '' }}>4</option>
                            <option value="5" selected {{ old('english_lvl') ? 'selected="selected"' : '' }}>5</option>
                        </select>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Select English language assessment from 1 to 5</span>
                    </div>
                    {{--Introduction score--}}
                    <div class="input-field">
                        <i class="material-icons prefix">dvr</i>
                        {!! Form::number('introductory_score', null, ['class' => 'validate', 'id' => 'introductory_score', 'min' => 50, 'max' => 100, 'step' => 1, 'required']) !!}
                        <label for="introductory_score">Indicate the introductory score</label>
                        <span class="helper-text" data-error="Choose a rating from 50 to 100" data-success="All is Ok">Choose a rating from 50 to 100</span>
                    </div>
                    {{--Upload image--}}
                    <div class="file-field input-field">
                        <div class="btn indigo waves-effect waves-light">
                            <span>File</span>
                            <input type="file" name="avatar" accept="image/*" required>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload user avatar">
                            <span class="helper-text" data-error="Only *.jpg *.png *.gif" data-success="All is Ok">Only *.jpg *.png *.gif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--Education and Job block--}}
        <div class="row">
            <div class="col s6">
                <div class="card-panel hoverable">
                    <h5 class="m-t-0 center-align">Education</h5>
                    <div class="input-field">
                        {!! Form::text('education_name', null, ['class' => 'validate', 'id' => 'education_name', 'required']) !!}
                        <label for="education_name">Name of the educational institution</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('education_speciality', null, ['class' => 'validate', 'id' => 'education_speciality', 'required']) !!}
                        <label for="education_speciality">Name of speciality</label>
                    </div>
                    <div class="input-field">
                        <select name="education_rank" required>
                            <option value="" disabled>Select degree</option>
                            <option value="bachelor" selected {{ old('education_rank') ? 'selected="selected"' : '' }}>Bachelor</option>
                            <option value="specialist" {{ old('education_rank') ? 'selected="selected"' : '' }}>Specialist</option>
                            <option value="master" {{ old('education_rank') ? 'selected="selected"' : '' }}>Master</option>
                        </select>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Select degree</span>
                    </div>
                </div>
            </div>
            <div class="col s6">
                <div class="card-panel hoverable">
                    <h5 class="m-t-0 center-align">Current or last job</h5>
                    <div class="input-field">
                        {!! Form::text('job_name', null, ['class' => 'validate', 'id' => 'job_name', 'required']) !!}
                        <label for="job_name">Name of organisation</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('job_position', null, ['class' => 'validate', 'id' => 'job_speciality', 'required']) !!}
                        <label for="job_speciality">Name of position</label>
                    </div>
                    <div class="input-field">
                        {!! Form::number('job_experience', null, ['class' => 'validate', 'id' => 'job_experience', 'min' => 1, 'max' => 50, 'step' => 1, 'required']) !!}
                        <label for="job_experience">Managerial experience, years</label>
                    </div>
                    <p>
                        <label>
                            <input type="checkbox" name="current_job" {{ old('current_job') ? 'selected="selected"' : '' }}/>
                            <span>This is my current job</span>
                        </label>
                    </p>
                </div>
            </div>
        </div>
        {{--Social block--}}
        <div class="row">
            <div class="col s12">
                <div class="card-panel hoverable">
                    <h5 class="m-t-0 center-align">Social networks</h5>
                    <div class="row">
                        <div class="input-field col s4">
                        <i class="material-icons prefix">insert_link</i>
                            {!! Form::text('social_facebook', null, ['class' => 'validate', 'id' => 'social_facebook']) !!}
                            <label for="social_facebook">Facebook</label>
                        </div>
                        <div class="input-field col s4">
                        <i class="material-icons prefix">insert_link</i>
                            {!! Form::text('social_twitter', null, ['class' => 'validate', 'id' => 'social_twitter']) !!}
                            <label for="social_twitter">Twitter</label>
                        </div>
                        <div class="input-field col s4">
                        <i class="material-icons prefix">insert_link</i>
                            {!! Form::text('social_linkedin', null, ['class' => 'validate', 'id' => 'social_linkedin']) !!}
                            <label for="social_linkedin">Linkedin</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
