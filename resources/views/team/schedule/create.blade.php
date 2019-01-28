@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-show-schedule-create', $team) }}
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
                            @if(Auth::user()->hasRole('teacher'))
                                <select class="icons" name="teacher_id" required readonly>
                                    <option value="{{Auth::user()->id}}" selected >{{Auth::user()->getShortName()}}</option>
                                </select>
                            @else
                                <select class="icons" name="teacher_id" required readonly>
                                @foreach($team->getTeachers() as $teacher)
                                    <option value="{{$teacher->id}}" {{ old('discipline_id') == $teacher->id ? 'selected="selected"' : '' }}>{{$teacher->getShortName()}}</option>
                                @endforeach
                                </select>
                            @endif
                        </div>
                        {{--Discipline--}}
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">view_list</i>
                            @if(Auth::user()->hasRole('teacher'))
                                <select name="discipline_id" required>
                                    <option value="" disabled>Choose a discipline</option>
                                    @foreach(Auth::user()->getTeacherDiscipline($team->name) as $discipline)
                                        <option value="{{$discipline->getDiscipline->id}}" {{ old('discipline_id') == $discipline->getDiscipline->id ? 'selected="selected"' : '' }}>{{$discipline->getDiscipline->display_name}}</option>
                                    @endforeach
                                </select>
                            @else
                                <select name="discipline_id" required>
                                    <option value="" disabled>Choose a discipline</option>
                                    @foreach($team->disciplines as $discipline)
                                        <option value="{{$discipline->getDiscipline->id}}" {{ old('discipline_id') == $discipline->getDiscipline->id ? 'selected="selected"' : '' }}>{{$discipline->getDiscipline->display_name}}</option>
                                    @endforeach
                                </select>
                            @endif
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
                            <select name="lesson">
                                <option value="" disabled selected>Select lesson</option>
                                <option value="1" selected>Lesson 1</option>
                                <option value="1" selected>Lesson 2</option>
                            </select>
                            <label>Time for lesson</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">devices_other</i>
                            <select multiple name="tools">
                                <option value="" disabled selected>Select tools for lesson</option>
                                <option value="projector" selected>Projector</option>
                                <option value="laptop">Laptop</option>
                                <option value="markers">Markers</option>
                                <option value="board">Board</option>
                                <option value="flipcharts">Flipcharts</option>
                                <option value="sound_speakers">Sound speakers</option>
                            </select>
                            <label>Tools for lesson</label>
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
