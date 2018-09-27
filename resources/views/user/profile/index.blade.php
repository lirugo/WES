@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('user-profile') }}
@endsection
@section('content')
    {!! Form::open(['route' => 'student.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
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
                        {!! Form::text('second_name_ua', $name->second_name, ['class' => 'validate', 'id' => 'second_name_ua', 'required']) !!}
                        <label for="second_name_ua">Second Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('name_ua', $name->name, ['class' => 'validate', 'id' => 'name_ua', 'required']) !!}
                        <label for="name_ua">Name</label>
                    </div>
                    <div class="input-field">
                        {!! Form::text('middle_name_ua', $name->middle_name, ['class' => 'validate', 'id' => 'middle_name_ua', 'required']) !!}
                        <label for="middle_name_ua">Middle Name</label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col s12 m6 l6">
            <div class="card hoverable" id="avatar">
                <div class="card-image">
                    <img :src="imgDataUrl">
                    <a class="btn-floating btn-large halfway-fab waves-effect waves-light red" @click="toggleShow"><i class="material-icons">edit</i></a>
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
                        url="/store/avatar"
                        :params="params"
                        :headers="headers"
                        img-format="png">
                </widget-avatar-cropper>
            </div>
            <div class="card-panel hoverable">
                <h5 class="m-t-0 center-align">General</h5>
                {{--Date of birth--}}
                <div class="input-field">
                    <i class="material-icons prefix">date_range</i>
                    {!! Form::text('date_of_birth', $user->date_of_birth.' ('.$user->getCountOfYear().' years)', ['class' => 'validate datepicker', 'id' => 'date_of_birth', 'disabled']) !!}
                    <label for="date_of_birth">Date of Birthday</label>
                    <span class="helper-text" data-error="wrong" data-success="All is Ok."></span>
                </div>
                {{--Email--}}
                <div class="input-field">
                    <i class="material-icons prefix">email</i>
                    {!! Form::email('email', $user->email, ['class' => 'validate', 'id' => 'email', 'disabled']) !!}
                    <label for="email">Email</label>
                    <span class="helper-text" data-error="wrong" data-success="All is Ok.">example@domain.com</span>
                </div>
                {{--Phone--}}
                <div class="input-field">
                    <i class="material-icons prefix">phone</i>
                    {!! Form::text('phone', $user->getPhone(), ['class' => 'validate', 'id' => 'phone', 'disabled']) !!}
                    <span class="helper-text" data-error="wrong" data-success="All is Ok.">Phone</span>
                </div>
                {{--Student--}}
                @if($user->hasRole('student'))
                    <div class="row m-b-0">
                        <div class="col s12 m4 l4">
                            {{--Gender--}}
                            <div class="input-field">
                                <i class="material-icons prefix">accessibility</i>
                                {!! Form::text('gender', ucfirst($user->gender), ['class' => 'validate', 'id' => 'gender', 'disabled']) !!}
                                <span class="helper-text" data-error="wrong" data-success="All is Ok.">Gender</span>
                            </div>
                        </div>
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
                        {!! Form::text('education_name', $education->name, ['class' => 'validate', 'id' => 'education_name', 'disabled']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Name of the educational institution</span>
                    </div>
                    <div class="input-field">
                        {!! Form::text('education_speciality', $education->speciality, ['class' => 'validate', 'id' => 'education_speciality', 'disabled']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Name of speciality</span>
                    </div>
                    <div class="input-field">
                        {!! Form::text('education_rank', $education->rank, ['class' => 'validate', 'id' => 'education_rank', 'disabled']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Education Rank</span>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach($user->jobs as $job)
            <div class="col s12 m6 l6">
                <div class="card-panel hoverable">
                    <h5 class="m-t-0 center-align">Job</h5>
                    <div class="input-field">
                        {!! Form::text('job_name', $job->name, ['class' => 'validate', 'id' => 'job_name', 'disabled']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Name of organisation</span>
                    </div>
                    <div class="input-field">
                        {!! Form::text('job_position', $job->position, ['class' => 'validate', 'id' => 'job_speciality', 'disabled']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Name of position</span>
                    </div>
                    <div class="input-field">
                        {!! Form::number('job_experience', $job->experience, ['class' => 'validate', 'id' => 'job_experience', 'min' => 1, 'max' => 50, 'step' => 1, 'required']) !!}
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Managerial experience, years</span>
                    </div>
                    @if($job->current_job)
                        <p>
                            <label>
                                <input type="checkbox" name="current_job" checked="checked" disabled/>
                                <span>This is my current job</span>
                            </label>
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    {{--Social block--}}
    {{--<div class="row">--}}
        {{--<div class="col s12 m12 l12">--}}
            {{--<div class="card-panel hoverable">--}}
                {{--<h5 class="m-t-0 center-align">Social networks</h5>--}}
                {{--<div class="row">--}}
                    {{--<div class="input-field col s12 m4 l4">--}}
                        {{--<i class="material-icons prefix">insert_link</i>--}}
                        {{--{!! Form::text('social_facebook', null, ['class' => 'validate', 'id' => 'social_facebook']) !!}--}}
                        {{--<label for="social_facebook">Facebook</label>--}}
                    {{--</div>--}}
                    {{--<div class="input-field col s12 m4 l4">--}}
                        {{--<i class="material-icons prefix">insert_link</i>--}}
                        {{--{!! Form::text('social_twitter', null, ['class' => 'validate', 'id' => 'social_twitter']) !!}--}}
                        {{--<label for="social_twitter">Twitter</label>--}}
                    {{--</div>--}}
                    {{--<div class="input-field col s12 m4 l4">--}}
                        {{--<i class="material-icons prefix">insert_link</i>--}}
                        {{--{!! Form::text('social_linkedin', null, ['class' => 'validate', 'id' => 'social_linkedin']) !!}--}}
                        {{--<label for="social_linkedin">Linkedin</label>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
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
                imgDataUrl: '/uploads/avatars/' + {!! json_encode($user->avatar) !!},
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
