@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('teacher-create') }}
@endsection

@section('content')
    {!! Form::open(['route' => 'teacher.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    {{--Name and General block--}}
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">@lang('app.Name')</h5>
                <blockquote>
                    @lang('app.Ukrainian language')
                </blockquote>
                <div class="input-field">
                    {!! Form::text('second_name_ua', null, ['class' => 'validate', 'id' => 'second_name_ua', 'required']) !!}
                    <label for="second_name_ua">@lang('app.Second Name')</label>
                </div>
                <div class="input-field">
                    {!! Form::text('name_ua', null, ['class' => 'validate', 'id' => 'name_ua', 'required']) !!}
                    <label for="name_ua">@lang('app.Name')</label>
                </div>
                <div class="input-field">
                    {!! Form::text('middle_name_ua', null, ['class' => 'validate', 'id' => 'middle_name_ua']) !!}
                    <label for="middle_name_ua">@lang('app.Middle Name')</label>
                </div>

                <blockquote>
                    @lang('app.Russian language')
                </blockquote>
                <div class="input-field">
                    {!! Form::text('second_name_ru', null, ['class' => 'validate', 'id' => 'second_name_ru', 'required']) !!}
                    <label for="second_name_ru">@lang('app.Second Name')</label>
                </div>
                <div class="input-field">
                    {!! Form::text('name_ru', null, ['class' => 'validate', 'id' => 'name_ru', 'required']) !!}
                    <label for="name_ru">@lang('app.Name')</label>
                </div>
                <div class="input-field">
                    {!! Form::text('middle_name_ru', null, ['class' => 'validate', 'id' => 'middle_name_ru']) !!}
                    <label for="middle_name_ru">@lang('app.Middle Name')</label>
                </div>

                <blockquote>
                    @lang('app.English language')
                </blockquote>
                <div class="input-field">
                    {!! Form::text('second_name_en', null, ['class' => 'validate', 'id' => 'second_name_en', 'required']) !!}
                    <label for="second_name_en">@lang('app.Second Name')</label>
                </div>
                <div class="input-field">
                    {!! Form::text('name_en', null, ['class' => 'validate', 'id' => 'name_en', 'required']) !!}
                    <label for="name_en">@lang('app.Name')</label>
                </div>
                <div class="input-field">
                    {!! Form::text('middle_name_en', null, ['class' => 'validate', 'id' => 'middle_name_en']) !!}
                    <label for="middle_name_en">@lang('app.Middle Name')</label>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card hoverable" id="avatar">
                <div class="card-image">
                    <img :src="imgDataUrl">
                    <a class="btn-floating btn-large halfway-fab waves-effect waves-light red" @click="toggleShow"><i class="material-icons">add</i></a>
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
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">@lang('app.General')</h5>
                {{--Date of birth--}}
                <div class="input-field">
                    <i class="material-icons prefix">date_range</i>
                    {!! Form::text('date_of_birth', null, ['class' => 'validate datepicker', 'id' => 'date_of_birth', 'required']) !!}
                    <label for="date_of_birth">@lang('app.Date of Birthday')</label>
                    <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')"></span>
                </div>
                {{--Email--}}
                <div class="input-field">
                    <i class="material-icons prefix">email</i>
                    {!! Form::email('email', null, ['class' => 'validate', 'id' => 'email', 'required']) !!}
                    <label for="email">@lang('app.Email')</label>
                    <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">example@domain.com</span>
                </div>
                {{--Password--}}
                <div class="input-field">
                    <i class="material-icons prefix">vpn_key</i>
                    <input id="password" type="password" name="password" class="validate" min="8" required>
                    <label for="password">@lang('app.Password')</label>
                    <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">@lang('app.Minimum 8 characters')</span>
                </div>
                {{--Password Confirmation--}}
                <div class="input-field">
                    <i class="material-icons prefix">vpn_key</i>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="validate" min="8" required>
                    <label for="password_confirmation">@lang('app.Password Confirmation')</label>
                </div>
                {{--Phone--}}
                <div class="row">
                    <div class="col s4">
                        {{--Dialing code--}}
                        <div class="input-field">
                            <i class="material-icons prefix">phone</i>
                            <select name="dialling_code">
                                <option value="" disabled>@lang('app.Code')</option>
                                @foreach (config('dialling_code') as $key => $name)
                                    <option value="{{ $key }}"{{ old('dialling_code') === $key ? 'selected="selected"' : '' }}>{{ $key }}</option>
                                @endforeach
                            </select>
                            <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">@lang('app.Country code')</span>
                        </div>
                    </div>
                    <div class="col s8">
                        {{--User phone--}}
                        <div class="input-field">
                            {!! Form::text('phone_number', null, ['class' => 'validate', 'id' => 'phone_number', 'required']) !!}
                            <label for="phone_number">XX XXX XX XX</label>
                            <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">@lang('app.Phone number')</span>
                        </div>
                    </div>
                </div>
                {{--Gender--}}
                <div class="input-field">
                    <i class="material-icons prefix">accessibility</i>
                    <select name="gender" required>
                        <option value="" disabled>@lang('app.Select gender')</option>
                        <option value="male" selected {{ old('gender') ? 'selected="selected"' : '' }}>@lang('app.Male')</option>
                        <option value="female" {{ old('gender') ? 'selected="selected"' : '' }}>@lang('app.Female')</option>
                    </select>
                    <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">@lang('app.Select a gender of teacher')</span>
                </div>
                {{--Science Degree--}}
                <div class="input-field">
                    <i class="material-icons prefix">school</i>
                    {!! Form::text('science_degree', null, ['class' => 'validate', 'id' => 'science_degree', 'required']) !!}
                    <label for="science_degree">@lang('app.Science Degree')</label>
                </div>
                {{--Academic Status--}}
                <div class="input-field">
                    <i class="material-icons prefix">school</i>
                    {!! Form::text('academic_status', null, ['class' => 'validate', 'id' => 'academic_status', 'required']) !!}
                    <label for="academic_status">@lang('app.Academic Status')</label>
                </div>
                {{--Teacher Status--}}
                <div class="input-field">
                    <i class="material-icons prefix">room</i>
                    <select name="teacher_status">
                        <option value="" disabled>@lang('app.Status')</option>
                        @foreach (config('teacher_status') as $key => $name)
                            <option value="{{ $key }}"{{ old('teacher_status') === $key ? 'selected="selected"' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">@lang('app.Teacher status')</span>
                </div>
                {{--Select disciplines--}}
                <div class="input-field">
                    <i class="material-icons prefix">subject</i>
                    <select multiple name="disciplines[]" required>
                        <option value="" disabled selected>@lang('app.Choose disciplines for teacher')</option>
                        @foreach($disciplines as $discipline)
                            <option value="{{$discipline->id}}">{{$discipline->display_name}}</option>
                        @endforeach
                    </select>
                    <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">@lang('app.Choose disciplines for teacher')</span>
                </div>
                {{--English lvl--}}
                <p>
                    <label>
                        <input type="checkbox" name="can_teach_in_english" {{ old('can_teach_in_english') ? 'selected="selected"' : '' }}/>
                        <span>@lang('app.Can teach in English')</span>
                    </label>
                </p>
            </div>
        </div>
    </div>
    {{--Education and Job block--}}
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">@lang('app.Education')</h5>
                <div class="input-field">
                    {!! Form::text('education_name', null, ['class' => 'validate', 'id' => 'education_name', 'required']) !!}
                    <label for="education_name">@lang('app.Name of the educational institution')</label>
                </div>
                <div class="input-field">
                    {!! Form::text('education_speciality', null, ['class' => 'validate', 'id' => 'education_speciality', 'required']) !!}
                    <label for="education_speciality">@lang('app.Name of speciality')</label>
                </div>
                <div class="input-field">
                    <select name="education_rank">
                        <option value="" disabled>@lang('app.Education Rank')</option>
                        @foreach (config('education_rank') as $key => $name)
                            <option value="{{ $key }}"{{ old('education_rank') === $key ? 'selected="selected"' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">@lang('app.Education Rank')</span>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">@lang('app.Current or last job')</h5>
                <div class="input-field">
                    {!! Form::text('job_name', null, ['class' => 'validate', 'id' => 'job_name', 'required']) !!}
                    <label for="job_name">@lang('app.Name of organisation')</label>
                </div>
                <div class="input-field">
                    {!! Form::text('job_position', null, ['class' => 'validate', 'id' => 'job_speciality', 'required']) !!}
                    <label for="job_speciality">@lang('app.Name of position')</label>
                </div>
                <div class="input-field">
                    {!! Form::number('job_experience', null, ['class' => 'validate', 'id' => 'job_experience', 'min' => 1, 'max' => 50, 'step' => 1, 'required']) !!}
                    <label for="job_experience">@lang('app.Managerial experience, years')</label>
                </div>
                <p>
                    <label>
                        <input type="checkbox" name="current_job" {{ old('current_job') ? 'selected="selected"' : '' }}/>
                        <span>@lang('app.This is my current job')</span>
                    </label>
                </p>
            </div>
        </div>
    </div>
    {{--Social block--}}
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">@lang('app.Social networks')</h5>
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
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <button type="submit" class="btn-floating btn-large green waves-effect waves-light">
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
                imgDataUrl: '/uploads/avatars/male.png',
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
