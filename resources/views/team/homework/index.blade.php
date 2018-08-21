@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-edit-homework', $team) }}
@endsection
@section('content')
    @if(Auth::user()->hasRole(['administrator', 'top-manager', 'manager', 'student']))
        <div class="row">
            @foreach($disciplines as $discipline)
                <div class="col s12 m6 l4">
                    <div class="card hoverable">
                        <div class="card-content">
                            <div class="row m-b-0">
                                <span class="card-title center-align">{{$discipline->getDiscipline->display_name}}</span>
                                <a href="#user"><img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$discipline->getTeacher->avatar)}}"></a>
                                <p class="m-t-20">{{$discipline->getTeacher->getShortName()}}</p>
                                <p>{{$discipline->getTeacher->email}}</p>
                                <p>{{$discipline->getTeacher->getPhone()}}</p>
                            </div>
                        </div>
                        <div class="card-action right-align">
                            <a href="{{url('/team/'.$team->name.'/homework/'.$discipline->getDiscipline->name)}}" class="indigo waves-effect waves-light btn-small right">Open</a>
                        </div>
                    </div>
                </div>
            @endforeach
            @if($disciplines->all() == null)
                <div class="row">
                    <div class="col s12">
                        <div class="card-panel orange white-text">
                            <h5 class="center-align m-t-0 m-b-0-">Sorry, but you do not have any discipline...</h5>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @elseif(Auth::user()->hasRole('teacher'))
        <div class="row">
            @foreach(Auth::user()->getTeacherDiscipline($team->name) as $discipline)
                <div class="col s12 m6 l4">
                    <div class="card hoverable">
                        <div class="card-content">
                            <div class="row m-b-0">
                                <span class="card-title center-align">{{$discipline->getDiscipline->display_name}}</span>
                                <a href="#user"><img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$discipline->getTeacher->avatar)}}"></a>
                                <p class="m-t-20">{{$discipline->getTeacher->getShortName()}}</p>
                                <p>{{$discipline->getTeacher->email}}</p>
                                <p>{{$discipline->getTeacher->getPhone()}}</p>
                            </div>
                        </div>
                        <div class="card-action right-align">
                            <a href="{{url('/team/'.$team->name.'/homework/'.$discipline->getDiscipline->name)}}" class="indigo waves-effect waves-light btn-small right">Open</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
