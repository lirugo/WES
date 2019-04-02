@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('teacher-show', $teacher) }}
@endsection

@section('content')
    {{--Social block--}}
    <div class="row">
        <div class="col s12 m8">
            <div class="card-panel small hoverable">
                <h5 class="m-t-0 m-b-20 center-align">@lang('app.Social networks')</h5>
                <div class="row m-b-0">
                    @foreach($teacher->socials as $social)
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
                    @if(count($teacher->socials) == 0)
                        <h6 class="center">@lang('app.Not have any social links.')</h6>
                    @endif
                </div>
                @if(Auth::user()->hasRole(['top-manager', 'manager']))
                    <div class="row m-b-0">
                        {!! Form::open(['route' => ['social.store', $teacher->id], 'method' => 'POST']) !!}
                        <div class="input-field col s3">
                            <select name="name" required>
                                <option value="" disabled>@lang('app.Select social')</option>
                                @foreach (config('social.name') as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-field col s6">
                            <input id="url" type="text" name="url" class="validate" required>
                            <label for="url">@lang('app.URL')</label>
                        </div>
                        <div class="input-field col s3">
                            <button class="btn waves-effect waves-light green" type="submit">@lang('app.Add')
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
                        :width="900"
                        :height="900"
                        lang-type='en'
                        no-rotate
                        url="/avatar/{{$teacher->id}}/update"
                        :params="params"
                        :headers="headers"
                        img-format="png">
                </widget-avatar-cropper>
            </div>
        </div>
    </div>
    {!! Form::open(['route' => ['teacher.update', $teacher->id]]) !!}
    {{--Name and General block--}}
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">@lang('app.Name')</h5>
                @foreach($teacher->names as $name)
                    <small>@lang('app.Language') - {{$name->language}}</small>
                    <div class="input-field">
                        {!! Form::text('second_name_'.$name->language, $name->second_name, ['class' => 'validate', 'id' => 'second_name_ua', 'required']) !!}
                        <label for="second_name_ua">@lang('app.Second Name')</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('name_'.$name->language, $name->name, ['class' => 'validate', 'id' => 'name_ua', 'required']) !!}
                        <label for="name_ua">@lang('app.Name')</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('middle_name_'.$name->language, $name->middle_name, ['class' => 'validate', 'id' => 'middle_name_ua']) !!}
                        <label for="middle_name_ua">@lang('app.Second Name')</label>
                    </div>
                    <div class="divider"></div>
                @endforeach
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="col s12">
                <div class="card-panel hoverable">
                    <h5 class="m-t-0 center-align">@lang('app.General')</h5>
                    {{--Date of birth--}}
                    <div class="input-field">
                        <i class="material-icons prefix">date_range</i>
                        {!! Form::text('date_of_birth', $teacher->date_of_birth, ['class' => 'validate datepicker', 'id' => 'date_of_birth', 'required', 'disabled']) !!}
                        <label for="date_of_birth">@lang('app.Date of Birthday')</label>
                        <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')"></span>
                    </div>
                    {{--Email--}}
                    <div class="input-field">
                        <i class="material-icons prefix">email</i>
                        {!! Form::email('email', $teacher->email, ['class' => 'validate', 'id' => 'email', 'required', 'disabled']) !!}
                        <label for="email">Email</label>
                    </div>
                    {{--Phone--}}
                    <div class="row m-b-0 m-t-0">
                        <div class="col s4">
                            {{--Dialing code--}}
                            <div class="input-field m-b-0 m-t-0">
                                <i class="material-icons prefix">phone</i>
                                <select name="dialling_code">
                                    <option value="" disabled>@lang('app.Country Code')</option>
                                    @foreach (config('dialling_code') as $key => $name)
                                        <option value="{{ $key }}"{{ $teacher->phones()->first()->getCode()->dialling_code == $key ? 'selected="selected"' : '' }}>{{ $key }}</option>
                                    @endforeach
                                </select>
                                <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">@lang('app.Code')</span>
                            </div>
                        </div>
                        <div class="col s8">
                            {{--User phone--}}
                            <div class="input-field m-b-0 m-t-0">
                                {!! Form::text('phone_number', $teacher->phones()->first()->phone_number, ['class' => 'validate', 'id' => 'phone_number', 'required']) !!}
                                <label for="phone_number">XX XXX XX XX</label>
                                <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">@lang('app.Phone number')</span>
                            </div>
                        </div>
                    </div>
                    {{--Gender--}}
                    <div class="input-field">
                        <i class="material-icons prefix">accessibility</i>
                        <select name="gender" required disabled>
                            <option value="" disabled>{{$teacher->gender}}</option>
                        </select>
                        <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">@lang('app.Gender')</span>
                    </div>
                    {{--Science Degree--}}
                    <div class="input-field">
                        <i class="material-icons prefix">school</i>
                        {!! Form::text('science_degree', $teacher->teacher->science_degree, ['class' => 'validate', 'id' => 'science_degree', 'required']) !!}
                        <label for="science_degree">@lang('app.Science Degree')</label>
                    </div>
                    {{--Academic Status--}}
                    <div class="input-field">
                        <i class="material-icons prefix">school</i>
                        {!! Form::text('academic_status', $teacher->teacher->academic_status, ['class' => 'validate', 'id' => 'academic_status', 'required']) !!}
                        <label for="academic_status">@lang('app.Academic Status')</label>
                    </div>
                    {{--Teacher Status--}}
                    <div class="input-field">
                        <i class="material-icons prefix">accessibility</i>
                        <select name="teacher_status">
                            <option value="" disabled>@lang('app.Teacher Status')</option>
                            @foreach (config('teacher_status') as $key => $name)
                                <option value="{{ $key }}"{{ $teacher->teacher->teacher_status == $key ? 'selected="selected"' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <label for="teacher_status">@lang('app.Teacher Status')</label>
                    </div>
                    {{--English lvl--}}
                    <p>
                        <label>
                            <input type="checkbox" name="can_teach_in_english" {{$teacher->teacher->can_teach_in_english ? "checked" : ""}}/>
                            <span>@lang('app.Can teach in English')</span>
                        </label>
                    </p>
                </div>
            </div>
        </div>
    </div>
    {{--Education and Job block--}}
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">@lang('app.Education')</h5>
                @foreach($teacher->educations as $education)
                    <div class="input-field">
                        {!! Form::text('education_name', $education->name, ['class' => 'validate', 'id' => 'education_name', 'required']) !!}
                        <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">@lang('app.Name of the educational institution')</span>
                    </div>
                    <div class="input-field">
                        {!! Form::text('education_speciality', $education->speciality, ['class' => 'validate', 'id' => 'education_speciality', 'required']) !!}
                        <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">@lang('app.Name of speciality')</span>
                    </div>
                    <div class="input-field">
                        <select name="education_rank">
                            <option value="" disabled>@lang('app.Education Rank')</option>
                            @foreach (config('education_rank') as $key => $name)
                                <option value="{{ $name }}"{{ $education->rank == $key ? 'selected="selected"' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <span class="helper-text" data-error="@lang('app.Wrong')" data-success="@lang('app.All is Ok')">@lang('app.Degree')</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">@lang('app.Current or last job')</h5>
                @foreach($teacher->jobs as $job)
                    <div class="input-field">
                        {!! Form::text('job_name', $job->name, ['class' => 'validate', 'id' => 'job_name', 'required']) !!}
                        <label for="job_name">@lang('app.Name of organisation')</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('job_position', $job->position, ['class' => 'validate', 'id' => 'job_speciality', 'required']) !!}
                        <label for="job_speciality">@lang('app.Name of position')</label>
                    </div>
                    <div class="input-field">
                        {!! Form::number('job_experience', $job->experience, ['class' => 'validate', 'id' => 'job_experience', 'min' => 1, 'max' => 50, 'step' => 1, 'required']) !!}
                        <label for="job_experience">@lang('app.Managerial experience, years')</label>
                    </div>
                    <p>
                        <label>
                            <input type="checkbox" name="current_job" {{$job->current_job ? "checked" : ""}}/>
                            <span>@lang('app.This is my current job')</span>
                        </label>
                    </p>
                @endforeach
            </div>
        </div>
        {{--Floating button--}}
        <div class="fixed-action-btn">
            <button type="submit" class="btn-floating btn-large green tooltipped" data-position="left" data-tooltip="@lang('app.Update Profile')">
                <i class="large material-icons">save</i>
            </button>
        </div>
        {!! Form::close() !!}
    </div>
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
                imgDataUrl: '/uploads/avatars/{!! $teacher->avatar !!}',
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
