@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-edit-schedule', $team) }}
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
@endsection
@section('content')
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card hoverable">
                <div class="card-content">
                    {!! $calendar->calendar() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card hoverable">
                <div class="card-content">
                    {!! Form::open(['route' => ['team.schedule.store', $team->name], 'method' => 'POST']) !!}
                        {{--Title--}}
                        <div class="input-field col s12">
                            <i class="material-icons prefix">format_align_justify</i>
                            <input id="title" value="{{ old('title') }}" name="title" type="text" class="validate" required>
                            <label for="title">Title</label>
                        </div>
                        {{--Teacher--}}
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">school</i>
                            <select class="icons" name="teacher_id" required>
                                <option value="" disabled selected>Choose a teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{$teacher->id}}" {{ old('teacher') == $teacher->id ? 'selected="selected"' : '' }} data-icon="{{asset('/uploads/avatars/'.$teacher->avatar)}}">{{$teacher->getShortName()}}</option>
                                @endforeach
                            </select>
                            <label for="icon_prefix">Select Teacher</label>
                        </div>
                        {{--Discipline--}}
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">view_list</i>

                            <select name="discipline_id" required>
                                <option value="" disabled selected>Choose a discipline</option>
                                @foreach($disciplines as $discipline)
                                    <option value="{{$discipline->id}}" {{ old('discipline') == $discipline->id ? 'selected="selected"' : '' }}>{{$discipline->display_name}}</option>
                                @endforeach
                            </select>
                            <label for="icon_prefix">Select Discipline</label>
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
                        <button class="btn waves-effect waves-light indigo" type="submit">Add to Schedule
                            <i class="material-icons right">send</i>
                        </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    {!! $calendar->script() !!}
@endsection