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
                    <div class="row m-b-0">
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
                                    <option value="" disabled>@lang('app.Choose a discipline')</option>
                                    @foreach(Auth::user()->getTeacherDiscipline($team->name) as $discipline)
                                        <option value="{{$discipline->getDiscipline->id}}" {{ old('discipline_id') == $discipline->getDiscipline->id ? 'selected="selected"' : '' }}>{{$discipline->getDiscipline->display_name}} - {{$discipline->leftHours($team->id, Auth::user()->id, $discipline->getDiscipline->id)}} hours left</option>
                                    @endforeach
                                </select>
                            @else
                                <select name="discipline_id" required>
                                    <option value="" disabled>@lang('app.Choose a discipline')</option>
                                    @foreach($team->disciplines as $discipline)
                                        <option value="{{$discipline->getDiscipline->id}}" {{ old('discipline_id') == $discipline->getDiscipline->id ? 'selected="selected"' : '' }}>{{$discipline->getDiscipline->display_name}}</option>
                                    @endforeach
                                </select>
                            @endif
                            <label for="discipline_id">@lang('app.Select Discipline')</label>
                        </div>
                        {{--Start date&time picker--}}
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">date_range</i>
                            <input id="start_date" value="{{ old('start_date') }}" name="start_date" type="text" class="datepickerDefault" required>
                            <label for="start_date">@lang('app.Select day')</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">access_time</i>
                            <select name="lesson">
                                <option value="" disabled selected>@lang('app.Select lecture')</option>
                                @foreach($team->lessonsTime as $time)
                                <option value="{{$time->id}}">@lang('app.Lecture') {{$time->position}} ({{\Carbon\Carbon::parse($time->start_time)->format('H:i')}} - {{\Carbon\Carbon::parse($time->end_time)->format('H:i')}})</option>
                                @endforeach
                            </select>
                            <label>@lang('app.Time for lecture')</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">devices_other</i>
                            <select multiple name="tools[]">
                                <option value="" disabled selected>@lang('app.Select tools for lesson')</option>
                                <option value="Projector" selected>@lang('app.Projector')</option>
                                <option value="Laptop">@lang('app.Laptop')</option>
                                <option value="Markers">@lang('app.Markers')</option>
                                <option value="Board">@lang('app.Board')</option>
                                <option value="Flipcharts">@lang('app.Flipcharts')</option>
                                <option value="Sound speakers">@lang('app.Sound speakers')</option>
                            </select>
                            <label>@lang('app.Tools for lesson')</label>
                        </div>
                        <div class="input-field col s12 m6 l6">
                            <i class="material-icons prefix">format_align_justify</i>
                            <input id="description" type="text" name="description" data-length="200">
                            <label for="description">@lang('app.Title')</label>
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var textNeedCount = document.querySelectorAll('#description');
            M.CharacterCounter.init(textNeedCount);
        });
    </script>
@endsection