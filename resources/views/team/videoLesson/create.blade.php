@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-video-lesson-create', $team) }}
@endsection
@section('content')
    {{--Show type group work--}}
    <div class="row">
        <div class="col s12 m6">
            <div class="card-panel">
                {!! Form::open(['route' => ['team.video-lesson.store', $team->name], 'enctype' => 'multipart/form-data']) !!}
                <div class="row m-b-0">
                    <div class="input-field col s10">
                        <input id="module" name="module" type="text" class="validate" required>
                        <label for="module">@lang('app.Module')</label>
                    </div>
                    <div class="input-field col s2">
                        <input id="part" name="part" type="number" min="1" value="1" max="10" class="validate" required>
                        <label for="part">@lang('app.Part')</label>
                    </div>

                    {{--Discipline--}}
                    <div class="input-field col s12 m6">
                        <select name="discipline_id" required>
                            <option value="" disabled>@lang('app.Choose a discipline')</option>
                            @role('teacher')
                            @foreach(Auth::user()->getTeacherDiscipline($team->name) as $discipline)
                                <option value="{{$discipline->getDiscipline->id}}" {{ old('discipline_id') == $discipline->getDiscipline->id ? 'selected="selected"' : '' }}>{{$discipline->getDiscipline->display_name}}</option>
                            @endforeach
                            @endrole
                            @role('manager')
                            @foreach($team->disciplines as $discipline)
                                <option value="{{$discipline->getDiscipline->id}}" {{ old('discipline_id') == $discipline->getDiscipline->id ? 'selected="selected"' : '' }}>{{$discipline->getDiscipline->display_name}}</option>
                            @endforeach
                            @endrole
                        </select>
                    </div>
                    <div class="input-field col s12 m6 m-b-15">
                        <input disabled/>
                        <label>
                            <input type="checkbox" name="public" @click="public ? public=false : public=true" />
                            <span>@lang('app.Public')</span>
                        </label>
                    </div>
                </div>
                <div class="row m-b-0">
                    <div class="input-field col s12 m4">
                        <i class="material-icons prefix">date_range</i>
                        <input id="date" value="{{ old('date') }}" name="date" type="text" class="datepickerDefault" required>
                        <label for="date">@lang('app.Date')</label>
                    </div>

                    {{--Start date&time picker--}}
                    <div class="input-field col s12 m4">
                        <i class="material-icons prefix">access_time</i>
                        <input id="start_time" value="{{ old('start_time') }}" name="start_time" type="text" class="timepicker" required>
                        <label for="start_time">@lang('app.Start Time')</label>
                    </div>
                    {{--End date&time picker--}}
                    <div class="input-field col s12 m4">
                        <i class="material-icons prefix">access_time</i>
                        <input id="end_time" value="{{ old('end_time') }}" name="end_time" type="text" class="timepicker" required>
                        <label for="end_time">@lang('app.End Time')</label>
                    </div>
                </div>

                <div class="file-field input-field  m-b-0">
                    <div class="btn indigo">
                        <span>@lang('app.File')</span>
                        <input type="file" name="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="@lang('app.Upload file')">
                    </div>
                </div>

                <div class="fixed-action-btn" id="activity-create">
                    <button type="submit" class="btn-floating btn-large waves-effect waves-light green"><i class="material-icons">save</i></button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection