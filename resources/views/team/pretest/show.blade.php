@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest-discipline-show', $team, $discipline, $pretest) }}
@endsection
@section('content')
    <div class="row">
        <div class="col s12 l6">
            <div class="card-panel">
                <div class="row m-b-0">
                    <div class="input-field col s12 m8">
                        <select name="discipline_id" disabled>
                            <option value="" disabled>Choose a discipline</option>
                            <option value="{{$discipline->id}}">{{$discipline->display_name}}</option>
                        </select>
                        <label for="discipline_id">Discipline</label>
                    </div>
                    <div class="input-field col s12 m4">
                        {!! Form::number('time', $pretest->time, ['placeholder' => 'Minutes', 'min' => 0, 'max' => 480, 'disabled']) !!}
                        <label for="time">Min for that test</label>
                    </div>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">title</i>
                    <input placeholder="Write name of pretest" name="name" id="name" type="text" class="validate"
                           value="{{$pretest->name}}" disabled>
                    <label for="name">Name</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">format_align_justify</i>
                    <textarea placeholder="Write description of pretest" name="description" id="description" type="text"
                              class="materialize-textarea" readonly>{{$pretest->description}}</textarea>
                    <label for="description">Description</label>
                </div>
                <div class="row">
                    {{--Start date&time picker--}}
                    <div class="input-field">
                        <i class="material-icons prefix">date_range</i>
                        <input id="start_date" value="{{$pretest->start_date}}" name="start_date" type="text"
                               class="datepickerDefault" disabled>
                        <label for="start_date">Start date</label>
                    </div>
                    {{--End date&time picker--}}
                    <div class="input-field">
                        <i class="material-icons prefix">date_range</i>
                        <input id="end_date" value="{{$pretest->end_date}}" name="end_date" type="text"
                               class="datepickerDefault" disabled>
                        <label for="end_date">End date</label>
                    </div>
                </div>
                <p>
                    <label>
                        <input type="checkbox" name="mark_in_journal" {{$pretest->mark_in_journal ? 'checked' : ''}}/>
                        <span>Mark in Journal</span>
                    </label>
                </p>
            </div>
        </div>
        <div class="col s12 l6">
            @foreach($pretest->files as $file)
                <div class="card-panel valign-wrapper">
                    {!! Form::open(['route' => ['team.pretest.getFile', $file->file], 'method' => 'POST']) !!}
                    <button class="btn waves-effect waves-light indigo" type="submit" name="action">{{$file->name}}
                        <i class="material-icons right">file_download</i>
                    </button>
                    {!! Form::close() !!}
                </div>
            @endforeach
        </div>
        @role('teacher')
        {{--Floating button--}}
        <div class="fixed-action-btn">
            <a href="{{url('/team/'.$team->name.'/pretest/create')}}" class="btn-floating btn-large green tooltipped" data-position="left"
               data-tooltip="Create Pretest">
                <i class="large material-icons">save</i>
            </a>
        </div>
        @endrole
    </div>
@endsection
