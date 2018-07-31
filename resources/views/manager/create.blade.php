@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => 'manager.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
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
        <div class="col s12 m6 l6">
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
        <div class="col s12 m6 l6">
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
    {{--Social block--}}
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">Social networks</h5>
                <div class="row">
                    <div class="input-field col s12 m4 l4">
                        <i class="material-icons prefix">insert_link</i>
                        {!! Form::text('social_facebook', null, ['class' => 'validate', 'id' => 'social_facebook']) !!}
                        <label for="social_facebook">Facebook</label>
                    </div>
                    <div class="input-field col s12 m4 l4">
                        <i class="material-icons prefix">insert_link</i>
                        {!! Form::text('social_twitter', null, ['class' => 'validate', 'id' => 'social_twitter']) !!}
                        <label for="social_twitter">Twitter</label>
                    </div>
                    <div class="input-field col s12 m4 l4">
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
