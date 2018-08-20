@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('student-team-teachers', $team) }}
@endsection
@section('content')
    <div class="row">
        @foreach($team->getTeachers() as $teacher)
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-image">
                        <img src="{{asset('/uploads/avatars/'.$teacher->avatar)}}">
                        <span class="card-title">{{$teacher->getShortName()}}</span>
                    </div>
                    <div class="card-content">
                        <span class="card-title center-align"></span>
                        <p></p>
                        <div class="divider m-t-10 m-b-10"></div>
                        <blockquote class="m-b-0 m-t-5"><small>Email - {{$teacher->email}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>Phone - {{$teacher->getPhone()}}</small></blockquote>
                    </div>
                </div>
            </div>
        @endforeach
        @if(count($team->getTeachers()) == 0)
            <div class="row">
                <div class="col s12">
                    <div class="card-panel orange white-text">
                        <h5 class="center-align m-t-0 m-b-0-">Sorry, but this group don't have any teachers yet...</h5>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
