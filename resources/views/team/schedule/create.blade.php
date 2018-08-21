@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-edit-schedule-create', $team) }}
@endsection
@section('content')
    {!! Form::open(['route' => ['team.schedule.store', $team->name], 'method' => 'POST']) !!}
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card hoverable">
                <div class="card-content">
                    <div class="row">
                        {{--Teacher--}}
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">school</i>
                            <select class="icons" name="teacher_id" required readonly>
                                <option value="{{Auth::user()->id}}" selected >{{Auth::user()->getShortName()}}</option>
                            </select>
                        </div>
                        {{--Discipline--}}
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">view_list</i>
                            <select name="discipline_id" required>
                                <option value="" disabled>Choose a discipline</option>
                                @foreach(Auth::user()->disciplines as $discipline)
                                    <option value="{{$discipline->get->id}}" {{ old('discipline_id') == $discipline->get->id ? 'selected="selected"' : '' }}>{{$discipline->get->display_name}}</option>
                                @endforeach
                            </select>
                            <label for="discipline_id">Select Discipline</label>
                        </div>
                        {{--Start date&time picker--}}
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">date_range</i>
                            <input id="start_date" value="{{ old('start_date') }}" name="start_date" type="text" class="datepickerDefault" required>
                            <label for="start_date">Start date</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">access_time</i>
                            <input id="start_time" value="{{ old('start_time') }}" name="start_time" type="text" class="timepicker" required>
                            <label for="start_time">Start Time</label>
                        </div>
                        {{--End date&time picker--}}
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">date_range</i>
                            <input id="end_date" value="{{ old('end_date') }}" name="end_date" type="text" class="datepickerDefault" required>
                            <label for="end_date">End date</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">access_time</i>
                            <input id="end_time" value="{{ old('end_time') }}" name="end_time" type="text" class="timepicker" required>
                            <label for="end_time">End Time</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <button type="submit" class="btn-floating btn-large green">
            <i class="large material-icons">save</i>
        </button>
    </div>
    {!! Form::close() !!}
@endsection
