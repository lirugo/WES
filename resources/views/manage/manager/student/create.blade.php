@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => 'manage.manager.student.store', 'method' => 'POST']) !!}
        {{--Header--}}
        <div class="row">
            <div class="col s12">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">Create a new student</span>
                        <button type="submit" class="waves-effect waves-light btn right tooltipped" data-tooltip="You sure? All data is correct?" data-position="top"><i class="material-icons right">send</i>Create a new user</button>
                        <a href="{{url('/manage')}}" class="waves-effect waves-light btn left m-r-10 tooltipped" data-tooltip="Information will be lost!" data-position="top"><i class="material-icons left">apps</i>Back to manage</a>
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
                        <input id="second_name_ua" name="second_name_ua" type="text" class="validate" required>
                        <label for="second_name_ua">Second Name</label>
                    </div>
                    <div class="input-field">
                        <input id="name_ua" name="name_ua" type="text" class="validate" required>
                        <label for="name_ua">Name</label>
                    </div>
                    <div class="input-field">
                        <input id="middle_name_ua" name="middle_name_ua" type="text" class="validate" required>
                        <label for="middle_name_ua">Middle Name</label>
                    </div>

                    <blockquote>
                        Russian language
                    </blockquote>
                    <div class="input-field">
                        <input id="second_name_ru" name="second_name_ru" type="text" class="validate" required>
                        <label for="second_name_ru">Second Name</label>
                    </div>
                    <div class="input-field">
                        <input id="name_ru" name="name_ru" type="text" class="validate" required>
                        <label for="name_ru">Name</label>
                    </div>
                    <div class="input-field">
                        <input id="middle_name_ru" name="middle_name_ru" type="text" class="validate" required>
                        <label for="middle_name_ru">Middle Name</label>
                    </div>

                    <blockquote>
                        English language
                    </blockquote>
                    <div class="input-field">
                        <input id="second_name_en" name="second_name_en" type="text" class="validate" required>
                        <label for="second_name_en">Second Name</label>
                    </div>
                    <div class="input-field">
                        <input id="name_en" name="name_en" type="text" class="validate" required>
                        <label for="name_en">Name</label>
                    </div>
                    <div class="input-field">
                        <input id="middle_name_en" name="middle_name_en" type="text" class="validate" required>
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
                        <input type="text" id="date_of_birth" name="date_of_birth" class="datepicker validate" required>
                        <label for="date_of_birth">Date of Birthday</label>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok."></span>
                    </div>
                    {{--Email--}}
                    <div class="input-field">
                        <i class="material-icons prefix">email</i>
                        <input id="email" type="email" name="email" class="validate" required>
                        <label for="email">Email</label>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">example@domain.com</span>
                    </div>
                    {{--Phone--}}
                    <div class="row">
                        <div class="col s4">
                            {{--Dialing code--}}
                            <div class="input-field">
                                <i class="material-icons prefix">phone</i>
                                <select name="dialing_code">
                                    <option value="" disabled>Code</option>
                                    <option value="" selected>+380</option>
                                    <option value="">+7</option>
                                </select>
                                <span class="helper-text" data-error="wrong" data-success="All is Ok.">Country code</span>
                            </div>
                        </div>
                        <div class="col s8">
                            {{--User phone--}}
                            <div class="input-field">
                                <input id="icon_telephone" name="phone_number" type="text" class="validate" required>
                                <label for="icon_telephone">XX XXX XX XX</label>
                                <span class="helper-text" data-error="wrong" data-success="All is Ok.">Phone number</span>
                            </div>
                        </div>
                    </div>
                    {{--Gender--}}
                    <div class="input-field">
                        <i class="material-icons prefix">accessibility</i>
                        <select name="gender" required>
                            <option value="" disabled>Select gender</option>
                            <option value="male" selected>Male</option>
                            <option value="female">Female</option>
                        </select>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Select a gender of student</span>
                    </div>
                    {{--English lvl--}}
                    <div class="input-field">
                        <i class="material-icons prefix">language</i>
                        <select name="english_lvl" required>
                            <option value="" disabled>Choose English lvl</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5" selected>5</option>
                        </select>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Select English language assessment from 1 to 5</span>
                    </div>
                    {{--Introduction score--}}
                    <div class="input-field">
                        <i class="material-icons prefix">dvr</i>
                        <input id="introductory_score" name="introductory_score" type="number" class="validate" min="50" max="100" step="1" required>
                        <label for="introductory_score">Indicate the introductory score</label>
                        <span class="helper-text" data-error="Choose a rating from 50 to 100" data-success="All is Ok">Choose a rating from 50 to 100</span>
                    </div>
                    {{--Upload image--}}
                    <div class="file-field input-field">
                        <div class="btn">
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
                        <input id="education_name" name="education_name" type="text" class="validate" required>
                        <label for="education_name">Name of the educational institution</label>
                    </div>
                    <div class="input-field">
                        <input id="education_speciality" name="education_speciality" type="text" class="validate" required>
                        <label for="education_speciality">Name of speciality</label>
                    </div>
                    <div class="input-field">
                        <select name="education_rank" required>
                            <option value="" disabled>Select degree</option>
                            <option value="bachelor" selected>Bachelor</option>
                            <option value="specialist">Specialist</option>
                            <option value="master">Master</option>
                        </select>
                        <span class="helper-text" data-error="wrong" data-success="All is Ok.">Select degree</span>
                    </div>
                </div>
            </div>
            <div class="col s6">
                <div class="card-panel hoverable">
                    <h5 class="m-t-0 center-align">Current or last job</h5>
                    <div class="input-field">
                        <input id="job_name" name="job_name" type="text" class="validate" required>
                        <label for="job_name">Name of organisation</label>
                    </div>
                    <div class="input-field">
                        <input id="job_speciality" name="job_speciality" type="text" class="validate" required>
                        <label for="job_speciality">Name of position</label>
                    </div>
                    <div class="input-field">
                        <input id="job_experience" name="job_experience" type="number" min="1" max="50" step="1" class="validate" required>
                        <label for="job_experience">Managerial experience, years</label>
                    </div>
                    <p>
                        <label>
                            <input type="checkbox" name="current_job" />
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
                            <input id="social_facebook" name="social_facebook" type="text" class="validate">
                            <label for="social_facebook">Facebook</label>
                        </div>
                        <div class="input-field col s4">
                        <i class="material-icons prefix">insert_link</i>
                            <input id="social_twitter" name="social_twitter" type="text" class="validate">
                            <label for="social_twitter">Twitter</label>
                        </div>
                        <div class="input-field col s4">
                        <i class="material-icons prefix">insert_link</i>
                            <input id="social_linkedin" name="social_linkedin" type="text" class="validate">
                            <label for="social_linkedin">Linkedin</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
