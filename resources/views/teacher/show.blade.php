@extends('layouts.app')

@section('content')
    {{--Header--}}
    <div class="row">
        <div class="col s12">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title center-align">Show teacher</span>
                    <a href="{{url('/manage')}}" class="indigo waves-effect waves-light btn left m-r-10"><i class="material-icons left">apps</i>Back to manage</a>
                </div>
            </div>
        </div>
    </div>
    {{--Name and General block--}}
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">Name</h5>
                @foreach($teacher->names as $name)
                    <small>Language - {{$name->language}}</small>
                    <div class="input-field">
                        {!! Form::text('second_name', $name->second_name, ['class' => 'validate', 'id' => 'second_name_ua', 'required', 'disabled']) !!}
                        <label for="second_name_ua">Second Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('name', $name->name, ['class' => 'validate', 'id' => 'name_ua', 'required', 'disabled']) !!}
                        <label for="name_ua">Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('middle_name', $name->middle_name, ['class' => 'validate', 'id' => 'middle_name_ua', 'required', 'disabled']) !!}
                        <label for="middle_name_ua">Middle Name</label>
                    </div>
                    <div class="divider"></div>
                @endforeach
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="col s12">
                <div class="card">
                    <div class="card-image">
                        <img src="{{asset('/uploads/avatars/'.$teacher->avatar)}}">
                        <span class="card-title">{{$teacher->getShortName()}}</span>
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="card-panel hoverable">
                    <h5 class="m-t-0 center-align">General</h5>
                    {{--Date of birth--}}
                    <div class="input-field">
                        <i class="material-icons prefix">date_range</i>
                        {!! Form::text('date_of_birth', $teacher->date_of_birth, ['class' => 'validate datepicker', 'id' => 'date_of_birth', 'required', 'disabled']) !!}
                        <label for="date_of_birth">Date of Birthday</label>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok."></span>
                    </div>
                    {{--Email--}}
                    <div class="input-field">
                        <i class="material-icons prefix">email</i>
                        {!! Form::email('email', $teacher->email, ['class' => 'validate', 'id' => 'email', 'required', 'disabled']) !!}
                        <label for="email">Email</label>
                    </div>
                    {{--Phone--}}
                    <div class="input-field">
                        <i class="material-icons prefix">phone</i>
                        {!! Form::text('phone_number', $teacher->getPhone(), ['class' => 'validate', 'id' => 'phone_number', 'required', 'disabled']) !!}
                        <label for="science_degree">Phone number</label>
                    </div>
                    {{--Gender--}}
                    <div class="input-field">
                        <i class="material-icons prefix">accessibility</i>
                        <select name="gender" required disabled>
                            <option value="" disabled>{{$teacher->gender}}</option>
                        </select>
                        <label for="science_degree">Gender</label>
                    </div>
                    {{--Science Degree--}}
                    <div class="input-field">
                        <i class="material-icons prefix">school</i>
                        {!! Form::text('science_degree', $teacher->teacher->science_degree, ['class' => 'validate', 'id' => 'science_degree', 'required', 'disabled']) !!}
                        <label for="science_degree">Science Degree</label>
                    </div>
                    {{--Academic Status--}}
                    <div class="input-field">
                        <i class="material-icons prefix">school</i>
                        {!! Form::text('academic_status', $teacher->teacher->academic_status, ['class' => 'validate', 'id' => 'academic_status', 'required', 'disabled']) !!}
                        <label for="academic_status">Academic Status</label>
                    </div>
                    {{--Teacher Status--}}
                    <div class="input-field">
                        <i class="material-icons prefix">accessibility</i>
                        <select name="teacher_status" required disabled>
                            <option value="" disabled>{{config('teacher_status.'.$teacher->teacher->teacher_status)}}</option>
                        </select>
                        <label for="teacher_status">Teacher Status</label>
                    </div>
                    {{--English lvl--}}
                    <p>
                        <label>
                            <input type="checkbox" name="can_teach_in_english" {{$teacher->teacher->can_teach_in_english ? "checked" : ""}} disabled/>
                            <span>Can teach in English</span>
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
                <h5 class="m-t-0 center-align">Education</h5>
                @foreach($teacher->educations as $education)
                    <div class="input-field">
                        {!! Form::text('education_name', $education->name, ['class' => 'validate', 'id' => 'education_name', 'required', 'disabled']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Name of the educational institution</span>
                    </div>
                    <div class="input-field">
                        {!! Form::text('education_speciality', $education->speciality, ['class' => 'validate', 'id' => 'education_speciality', 'required', 'disabled']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Name of speciality</span>
                    </div>
                    <div class="input-field">
                        {!! Form::text('education_rank', $education->rank, ['class' => 'validate', 'id' => 'education_rank', 'required', 'disabled']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Degree</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">Current or last job</h5>
                @foreach($teacher->jobs as $job)
                    <div class="input-field">
                        {!! Form::text('job_name', $job->name, ['class' => 'validate', 'id' => 'job_name', 'required', 'disabled']) !!}
                        <label for="job_name">Name of organisation</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('job_position', $job->position, ['class' => 'validate', 'id' => 'job_speciality', 'required', 'disabled']) !!}
                        <label for="job_speciality">Name of position</label>
                    </div>
                    <div class="input-field">
                        {!! Form::number('job_experience', $job->experience, ['class' => 'validate', 'id' => 'job_experience', 'min' => 1, 'max' => 50, 'step' => 1, 'required', 'disabled']) !!}
                        <label for="job_experience">Managerial experience, years</label>
                    </div>
                    <p>
                        <label>
                            <input type="checkbox" name="current_job" {{$job->current_job ? "checked" : ""}} disabled/>
                            <span>This is my current job</span>
                        </label>
                    </p>
                @endforeach
            </div>
        </div>
    </div>
    {{--Social block--}}
    <div class="row">
        <div class="col s12">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">Social networks</h5>
                <div class="row">
                    @foreach($teacher->socials as $social)
                        <div class="input-field col s12 m6 l4">
                            <i class="material-icons prefix">insert_link</i>
                            <label for="social_facebook"><a href="{{$social->url}}">{{$social->name}}</a></label>
                        </div>
                    @endforeach
                    @if(count($teacher->socials) == 0)
                        <h6 class="center">Not have any social links.</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection