@extends('layouts.app')

@section('content')
    {{--Header--}}
    <div class="row">
        <div class="col s12">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title center-align">Edit teacher</span>
                    <a href="{{url('/teacher')}}" class="indigo waves-effect waves-light btn left m-r-10"><i class="material-icons left">apps</i>Back to teachers</a>
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
                        {!! Form::text('second_name', $name->second_name, ['class' => 'validate', 'id' => 'second_name_ua', 'required']) !!}
                        <label for="second_name_ua">Second Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('name', $name->name, ['class' => 'validate', 'id' => 'name_ua', 'required']) !!}
                        <label for="name_ua">Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('middle_name', $name->middle_name, ['class' => 'validate', 'id' => 'middle_name_ua', 'required']) !!}
                        <label for="middle_name_ua">Middle Name</label>
                    </div>
                    <div class="divider"></div>
                @endforeach
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="col s12">
                <div class="card hoverable" id="avatar">
                    <div class="card-image">
                        <img :src="imgDataUrl">
                        <a class="btn-floating btn-large halfway-fab waves-effect waves-light red" @click="toggleShow"><i class="material-icons">add</i></a>
                    </div>
                    <input name="avatar" type="hidden" value="{{$teacher->avatar}}" v-model="avatarName"/>
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
                            url="/store/avatar"
                            :params="params"
                            :headers="headers"
                            img-format="png">
                    </widget-avatar-cropper>
                </div>
            </div>
            <div class="col s12">
                <div class="card-panel hoverable">
                    <h5 class="m-t-0 center-align">General</h5>
                    {{--Date of birth--}}
                    <div class="input-field">
                        <i class="material-icons prefix">date_range</i>
                        {!! Form::text('date_of_birth', $teacher->date_of_birth, ['class' => 'validate datepicker', 'id' => 'date_of_birth', 'required']) !!}
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
                        {!! Form::text('phone_number', $teacher->getPhone(), ['class' => 'validate', 'id' => 'phone_number', 'required']) !!}
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
                        {!! Form::text('science_degree', $teacher->teacher->science_degree, ['class' => 'validate', 'id' => 'science_degree', 'required']) !!}
                        <label for="science_degree">Science Degree</label>
                    </div>
                    {{--Academic Status--}}
                    <div class="input-field">
                        <i class="material-icons prefix">school</i>
                        {!! Form::text('academic_status', $teacher->teacher->academic_status, ['class' => 'validate', 'id' => 'academic_status', 'required']) !!}
                        <label for="academic_status">Academic Status</label>
                    </div>
                    {{--Teacher Status--}}
                    <div class="input-field">
                        <i class="material-icons prefix">room</i>
                        <select name="teacher_status">
                            <option value="" disabled>Status</option>
                            @foreach (config('teacher_status') as $key => $name)
                                <option value="{{ $key }}"{{ $teacher->teacher->teacher_status === $key ? 'selected="selected"' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Teacher status</span>
                    </div>
                    {{--English lvl--}}
                    <p>
                        <label>
                            <input type="checkbox" name="can_teach_in_english" {{$teacher->teacher->can_teach_in_english ? "checked" : ""}}/>
                            <span>Can teach in English</span>
                        </label>
                    </p>
                </div>
            </div>
        </div>
    </div>
    {{--Add a new Disciplines--}}
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                {!! Form::open(['route' => ['teacher.discipline.store',$teacher->id], 'method' => 'POST']) !!}
                <h5 class="card-title m-t-0 m-b-0 center-align">Add a new discipline.</h5>
                <div class="input-field">
                    <select name="discipline" required>
                        <option value="" disabled selected>Choose a discipline</option>
                        @foreach($disciplines as $discipline)
                            <option value="{{$discipline->id}}">{{$discipline->display_name}}</option>
                        @endforeach
                    </select>
                    <label>All disciplines</label>
                </div>
                <button type="submit" class="indigo waves-effect waves-light btn"><i class="material-icons right">add_circle_outline</i>Add a discipline</button>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="card-title m-t-0 m-b-0 center-align">All disciplines of the teacher.</h5>
                @foreach($teacher->disciplines as $discipline)
                        <div class="input-field">
                            {!! Form::text('discipline', $discipline->get->display_name, ['class' => 'validate', 'id' => 'academic_status', 'disabled']) !!}
                        </div>
                @endforeach
                @if(count($teacher->disciplines) == 0)
                    <h6 class="center-align">Not have any yet...</h6>
                @endif
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
                                <option value="{{ $key }}"{{ $education->rank === $name ? 'selected="selected"' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Education Rank</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">Current or last job</h5>
                @foreach($teacher->jobs as $job)
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
                    @endif
                </div>
            </div>
        </div>
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
                imgDataUrl: '/uploads/avatars/' + {!! json_encode($teacher->avatar) !!},
                avatarName: {!! json_encode($teacher->avatar) !!}
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

