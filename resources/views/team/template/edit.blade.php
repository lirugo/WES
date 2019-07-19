@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-template-edit', $template) }}
@endsection
@section('content')
    {{--Name and General block--}}
    <div class="row m-b-5">
        <div class="col s12 m6 l8">
            <div class="card-panel hoverable">
                <div class="input-field">
                    <i class="material-icons prefix">attachment</i>
                    {!! Form::text('name', $template->name, ['class' => 'validate', 'id' => 'name', 'required', 'disabled']) !!}
                    <label for="name">@lang('app.Name')</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">group</i>
                    {!! Form::text('display_name', $template->display_name, ['class' => 'validate', 'id' => 'display_name', 'required']) !!}
                    <label for="display_name">@lang('app.Displaying Name')</label>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l4">
            <div class="card-panel hoverable">
                {!! Form::open(['route' => ['team.template.teacher.store',$template->name], 'method' => 'POST']) !!}
                <h5 class="center-align m-b-30">@lang('app.Add a new teacher')</h5>
                <div class="input-field">
                    <select class="icons" name="teacher" required>
                        <option value="" disabled selected>@lang('app.Choose a new teacher')</option>
                        @foreach($teachers as $teacher)
                            <option value="{{$teacher->id}}" data-icon="{{asset('/uploads/avatars/'.$teacher->avatar)}}">{{$teacher->getShortName()}}</option>
                        @endforeach
                    </select>
                    <label>@lang('app.All teachers')</label>
                </div>
                <div class="input-field">
                    <select name="teacher_discipline" required>
                        <option value="" disabled selected>@lang('app.Choose a discipline')</option>
                        @foreach($disciplines as $discipline)
                            <option value="{{$discipline->id}}">{{$discipline->display_name}}</option>
                        @endforeach
                    </select>
                    <label>All disciplines</label>
                </div>
                <div class="input-field">
                    <input id="hours" name="hours" type="number" min="1" max="10000" class="validate" required>
                    <label for="hours">@lang('app.Count of Hours')</label>
                </div>
                <button type="submit" class="indigo waves-effect waves-light btn right"><i class="material-icons right">add_circle_outline</i>@lang('app.Add a New Teacher')</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{--List of Disciplines--}}
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <h6 class="card-title m-t-0 m-b-0 center-align">@lang('app.Disciplines of this group')</h6>
            </div>
        </div>
        @foreach($template->disciplines as $discipline)
            <div class="col s12 m4 l4">
                <div class="card-panel hoverable p-b-30">
                    <blockquote class="m-t-0">{{$discipline->getDiscipline->display_name}}</blockquote>
                    <a href="#user"><img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$discipline->getTeacher->avatar)}}"></a>
                    <p class="card-title m-t-25 m-b-0">{{$discipline->getTeacher->getShortName()}}</p>
                    <p class="card-title m-t-0 m-b-0">{{$discipline->getTeacher->email}}</p>
                    <p class="card-title m-t-0 m-b-0">{{$discipline->getTeacher->getPhone()}}</p>
                    <p class="card-title m-t-0">@lang('app.Hours') - {{$discipline->hours}}</p>
                    {!! Form::open(['route' => ['team.template.discipline.delete', $template->id, $discipline->getDiscipline->id]]) !!}
                        <button type="submit" class="red darken-1 waves-effect waves-light btn"><i class="material-icons right">delete</i>@lang('app.Delete')</button>
                    {!! Form::close() !!}
                </div>
            </div>
        @endforeach
    </div>
@endsection
