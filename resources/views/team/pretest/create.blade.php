@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest-create', $team) }}
@endsection
@section('content')
    <div class="row">
        <div class="col s12 l6">
            <div class="card-panel">
                <div class="input-field">
                    <i class="material-icons prefix">title</i>
                    <input placeholder="Write name of pretest" name="name" id="name" type="text" class="validate">
                    <label for="name">Name</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">format_align_justify</i>
                    <input placeholder="Write description of pretest" name="description" id="description" type="text"
                           class="validate">
                    <label for="description">Description</label>
                </div>
                <div class="row">
                    {{--Start date&time picker--}}
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">date_range</i>
                        <input id="start_date" value="{{ old('start_date') }}" name="start_date" type="text"
                               class="datepickerDefault" required>
                        <label for="start_date">Start date</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">access_time</i>
                        <input id="start_time" value="{{ old('start_time') }}" name="start_time" type="text"
                               class="timepicker" required>
                        <label for="start_time">Start Time</label>
                    </div>
                    {{--End date&time picker--}}
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">date_range</i>
                        <input id="end_date" value="{{ old('end_date') }}" name="end_date" type="text"
                               class="datepickerDefault" required>
                        <label for="end_date">End date</label>
                    </div>
                    <div class="input-field col s12 m6 l6">
                        <i class="material-icons prefix">access_time</i>
                        <input id="end_time" value="{{ old('end_time') }}" name="end_time" type="text"
                               class="timepicker" required>
                        <label for="end_time">End Time</label>
                    </div>
                </div>
                <p>
                    <label>
                        <input type="checkbox" name="mark_in_journal"/>
                        <span>Mark in Journal</span>
                    </label>
                </p>
            </div>
        </div>
        <div class="col s12 l6">
            <div class="card-panel">
                <div class="input-field">
                    <i class="material-icons prefix">attachment</i>
                    <input placeholder="Write name of education material" name="name" id="name" type="text" class="validate">
                    <label for="name">File</label>
                </div>
                <div class="file-field input-field">
                    <div class="btn indigo">
                        <span>File</span>
                        <input type="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" placeholder="Upload file" type="text">
                    </div>
                </div>
                <a class="btn-floating btn-large waves-effect waves-light red right"><i class="material-icons">add</i></a>

            </div>
        </div>
    </div>
    @role('teacher')
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <a href="{{url('/team/'.$team->name.'/pretest/create')}}" class="btn-floating btn-large green tooltipped"
           data-position="left"
           data-tooltip="Save">
            <i class="large material-icons">save</i>
        </a>
    </div>
    @endrole
@endsection
