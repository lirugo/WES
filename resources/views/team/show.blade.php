@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-show', $team) }}
@endsection
@section('content')
    {{--Name and Manager block--}}
    <div class="row">
        {!! Form::open(['route' => ['team.update', $team->name], 'method' => 'POST']) !!}
            <div class="col s12 l6">
                <div class="card-panel hoverable">
                    <div class="input-field">
                        <i class="material-icons prefix">attachment</i>
                        {!! Form::text('name', $team->name, ['class' => 'validate', 'id' => 'name', 'required', 'disabled']) !!}
                        <label for="name">Name</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">group</i>
                        {!! Form::text('display_name', $team->display_name, ['class' => 'validate', 'id' => 'display_name', 'required']) !!}
                        <label for="display_name">Displaying Name</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">format_align_justify</i>
                        {!! Form::textarea('description', $team->description, ['class' => 'validate materialize-textarea', 'id' => 'description', 'required']) !!}
                        <label for="description">Description</label>
                    </div>
                    @role('manager')
                    <button type="submit" class="yellow darken-4 waves-effect waves-light btn"><i class="material-icons right">update</i>Update</button>
                    @endrole
                </div>
            </div>
        {!! Form::close() !!}
        <div class="col s12 l6">
            <div class="s12">
                <div class="card-panel indigo white-text m-b-0">
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
            <div class="col s12 l6">
                <div class="card-panel hoverable">
                    @if(Auth::user()->hasRole('manager'))
                    <div class="right">
                        @if(!$team->isHeadman($student->id))
                            {!! Form::open(['route' => ['team.setHeadman', $team->name], 'method' => 'POST', 'id' => 'headman-form']) !!}
                                <button type="submit" data-position="left" data-tooltip="Set like a headman" class="waves-effect waves-light btn btn-small indigo tooltipped"><i class="material-icons">add_circle_outline</i></button>
                                <input type="hidden" name="student_id" value="{{$student->id}}"/>
                            {!! Form::close() !!}
                        @endif
                    </div>
                    @endif
                    <a href="#user">
                        @if($team->isHeadman($student->id))
                            <img src="{{asset('/images/icon/teams/headman_en.png')}}" class="left" style="position: absolute; margin: -15px 0 0 -10px;" width="50px"/>
                        @endif
                        <img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$student->avatar)}}">
                    </a>
                    <p class="card-title m-t-0 m-b-0">{{$student->getShortName()}}</p>
                    <p class="card-title m-t-0 m-b-0">{{$student->email}}</p>
                    <p class="card-title m-t-0 m-b-0">{{$student->getPhone()}}</p>
                    @if(Auth::user()->hasRole(['administrator', 'top-manager', 'manager', 'teacher']))
                        <p class="card-title m-t-0">{{$student->getCountOfYear()}} years old</p>
                    @endif
                    @if(Auth::user()->hasRole(['administrator', 'top-manager', 'manager']))
                        {!! Form::open(['route' => ['team.student.delete', $team->id, $student->id]]) !!}
                        <button type="submit" class="red darken-1 waves-effect waves-light btn btn-small"><i class="material-icons">delete</i></button>
                        <a href="{{url('/student',$student->id)}}" class="indigo waves-effect waves-light btn btn-small right"><i class="material-icons">open_in_new</i></a>
                        {!! Form::close() !!}
                    @endif
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
            <div class="col s12 l6">
                <div class="card-panel hoverable height-200px">
                    <blockquote class="m-t-0">{{$discipline->getDiscipline->display_name}}</blockquote>
                    <a href="#user"><img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$discipline->getTeacher->avatar)}}"></a>
                    <p class="card-title m-t-10 m-b-0">{{$discipline->getTeacher->getShortName()}}</p>
                    <p class="card-title m-t-0 m-b-0">{{$discipline->getTeacher->email}}</p>
                    <p class="card-title m-t-0 m-b-0">{{$discipline->getTeacher->getPhone()}}</p>
                    <p class="card-title m-t-0 m-b-0">Hours - {{$discipline->hours}}</p>
                    @if(Auth::user()->hasRole(['top-manager', 'manager', 'teacher']))
                        <p class="card-title m-t-0">{{$discipline->getTeacher->getCountOfYear()}} years old</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if(Auth::user()->hasRole(['administrator', 'top-manage', 'manager']))
        <div class="row">
            <div class="col s12 m6 l4">
                <div class="card-panel hoverable">
                    {!! Form::open(['route' => ['team.student.store',$team->name], 'method' => 'POST']) !!}
                    <h5 class="center-align m-b-30">Add a new student</h5>
                    <div class="input-field">
                        <select class="icons" name="student" required>
                            <option value="" disabled selected>Choose a new student</option>
                            @foreach($students as $student)
                                <option value="{{$student->id}}" data-icon="{{asset('/uploads/avatars/'.$student->avatar)}}">{{$student->getShortName()}}</option>
                            @endforeach
                        </select>
                        <label>All students</label>
                    </div>
                    <button type="submit" class="indigo waves-effect waves-light btn right"><i class="material-icons right">add_circle_outline</i>Add a new student</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endif

    {{--Floating button--}}
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large red">
            <i class="large material-icons">mode_edit</i>
        </a>
        <ul>
            <li><a class="btn-floating green tooltipped" data-position="left" data-tooltip="Group Work" href="{{url('/team/'.$team->name.'/group-work')}}"><i class="material-icons">group</i></a></li>
            <li><a class="btn-floating green tooltipped" data-position="left" data-tooltip="Activity" href="{{url('/team/'.$team->name.'/activity')}}"><i class="material-icons">home</i></a></li>
            <li><a class="btn-floating green tooltipped" data-position="left" data-tooltip="Educational Materials" href="{{url('/team/'.$team->name.'/material')}}"><i class="material-icons">import_contacts</i></a></li>
            <li><a class="btn-floating blue tooltipped" data-position="left" data-tooltip="Schedule" href="{{url('/team/'.$team->name.'/schedule')}}"><i class="material-icons">access_time</i></a></li>
            <li><a class="btn-floating orange tooltipped" data-position="left" data-tooltip="Pretest" href="{{url('/team/'.$team->name.'/pretest')}}"><i class="material-icons">border_color</i></a></li>
        </ul>
    </div>
@endsection
@section('scripts')
@endsection