@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('student-team-dashboard', $team) }}
@endsection
@section('content')
    {{--Name and General block--}}
    <div class="row">
        <div class="col s12 m6 l8">
            <div class="card-panel hoverable">
                <div class="input-field">
                    <i class="material-icons prefix">attachment</i>
                    {!! Form::text('name', $team->name, ['class' => 'validate', 'id' => 'name', 'required', 'disabled']) !!}
                    <label for="name">Name</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">group</i>
                    {!! Form::text('display_name', $team->display_name, ['class' => 'validate', 'id' => 'display_name', 'required', 'disabled']) !!}
                    <label for="display_name">Displaying Name</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">format_align_justify</i>
                    {!! Form::textarea('description', $team->description, ['class' => 'validate materialize-textarea', 'id' => 'description', 'required', 'disabled']) !!}
                    <label for="description">Description</label>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l4">
            <div class="s12">
                <div class="card-panel indigo white-text">
                    <h6 class="card-title m-t-0 m-b-0 center-align">Manager of this group.</h6>
                </div>
            </div>
            <div class="s12">
                <div class="card-panel hoverable">
                    <a href="#user"><img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$team->getOwner()->avatar)}}"></a>
                    <p class="card-title m-b-0">{{$team->getOwner()->getShortName()}}</p>
                    <p class="card-title m-t-0 m-b-0">{{$team->getOwner()->email}}</p>
                    <p class="card-title m-t-0">{{$team->getOwner()->getPhone()}}</p>
                    <a class="indigo waves-effect waves-light btn-small right"><i class="material-icons right">message</i>Have question?</a>
                </div>
            </div>
        </div>
    </div>
    {{--Display students of this group--}}
    <div class="row">
        <div class="col s12">
            <div class="card-panel indigo white-text m-b-0">
                <h6 class="card-title m-t-0 m-b-0 center-align">Students of this group</h6>
            </div>
        </div>
        @foreach($team->getStudents() as $student)
            <div class="col s12 m6 l4">
                <div class="card-panel hoverable">
                    <a href="#user"><img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$student->avatar)}}"></a>
                    <p class="card-title m-b-0">{{$student->getShortName()}}</p>
                    <p class="card-title m-t-0 m-b-0">{{$student->email}}</p>
                    <p class="card-title m-t-0">{{$student->getPhone()}}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{--Display discipline of this group--}}
    <div class="row">
        <div class="col s12">
            <div class="card-panel indigo white-text m-b-0">
                <h6 class="card-title m-t-0 m-b-0 center-align">Disciplines of this group</h6>
            </div>
        </div>
        @foreach($team->disciplines as $discipline)
            <div class="col s12 m6 l4">
                <div class="card-panel hoverable p-b-30">
                    <blockquote class="m-t-0">{{$discipline->getDiscipline->display_name}}</blockquote>
                    <a href="#user"><img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$discipline->getTeacher->avatar)}}"></a>
                    <p class="card-title m-t-10 m-b-0">{{$discipline->getTeacher->getShortName()}}</p>
                    <p class="card-title m-t-0 m-b-0">{{$discipline->getTeacher->email}}</p>
                    <p class="card-title m-t-0 m-b-0">{{$discipline->getTeacher->getPhone()}}</p>
                    <p class="card-title m-t-0">Hours - {{$discipline->hours}}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col s12">
            <div class="card-panel hoverable">
                <h4>Last action etc.</h4>
            </div>
        </div>
    </div>
@endsection
