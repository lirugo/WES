@extends('layouts.app')

@section('content')
    {{--Header--}}
    <div class="row">
        <div class="col s12">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title center-align">{{$team->display_name}}</span>
                    <a href="{{url('/team')}}" class="indigo waves-effect waves-light btn left m-r-10"><i class="material-icons left">groups</i>Back to groups</a>
                </div>
            </div>
        </div>
    </div>
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
                    {!! Form::text('display_name', $team->display_name, ['class' => 'validate', 'id' => 'display_name', 'required']) !!}
                    <label for="display_name">Displaying Name</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">format_align_justify</i>
                    {!! Form::textarea('description', $team->description, ['class' => 'validate materialize-textarea', 'id' => 'description', 'required']) !!}
                    <label for="description">Description</label>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l4">
            <div class="s12">
                <div class="card-panel">
                    <h6 class="card-title m-t-0 m-b-0 center-align">Manager of this group.</h6>
                </div>
            </div>
            <div class="s12">
                <div class="card-panel hoverable">
                    <a href="#user"><img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.Auth::user()->avatar)}}"></a>
                    <p class="card-title m-b-0">{{$team->getOwner()->getShortName()}}</p>
                    <p class="card-title m-t-0 m-b-0">{{$team->getOwner()->email}}</p>
                    <p class="card-title m-t-0">{{$team->getOwner()->getPhone()}}</p>
                    <a class="indigo waves-effect waves-light btn-small right"><i class="material-icons right">message</i>Have question?</a>
                </div>
            </div>
        </div>
    </div>
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
                <button type="submit" class="indigo waves-effect waves-light btn"><i class="material-icons right">add_circle_outline</i>Add a new student</button>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col s12 m6 l4">
            <div class="card-panel hoverable">
                {!! Form::open(['route' => ['team.teacher.store',$team->name], 'method' => 'POST']) !!}
                <h5 class="center-align m-b-30">Add a new teacher</h5>
                <div class="input-field">
                    <select class="icons" name="teacher" required>
                        <option value="" disabled selected>Choose a new teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{$teacher->id}}" data-icon="{{asset('/uploads/avatars/'.$teacher->avatar)}}">{{$teacher->getShortName()}}</option>
                        @endforeach
                    </select>
                    <label>All teachers</label>
                </div>
                <button type="submit" class="indigo waves-effect waves-light btn"><i class="material-icons right">add_circle_outline</i>Add a new teacher</button>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col s12 m6 l4">
            <div class="s12">
                <div class="card-panel">
                    <h6 class="card-title m-t-0 m-b-0 center-align">Students of this group</h6>
                </div>
            </div>
            <div class="s12">
                @foreach($team->getStudents() as $student)
                    <div class="card-panel hoverable">
                        <a href="#user"><img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$student->avatar)}}"></a>
                        <p class="card-title m-b-0">{{$student->getShortName()}}</p>
                        <p class="card-title m-t-0 m-b-0">{{$student->email}}</p>
                        <p class="card-title m-t-0">{{$student->getPhone()}}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col s12 m6 l4 offset-l8">
            <div class="s12">
                <div class="card-panel">
                    <h6 class="card-title m-t-0 m-b-0 center-align">Teachers of this group</h6>
                </div>
            </div>
            <div class="s12">
                @foreach($team->getTeachers() as $student)
                    <div class="card-panel hoverable">
                        <a href="#user"><img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$student->avatar)}}"></a>
                        <p class="card-title m-b-0">{{$student->getShortName()}}</p>
                        <p class="card-title m-t-0 m-b-0">{{$student->email}}</p>
                        <p class="card-title m-t-0">{{$student->getPhone()}}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
