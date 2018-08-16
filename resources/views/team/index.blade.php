@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team') }}
@endsection
@section('content')
    <div class="row">
        @foreach($teams as $team)
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">{{$team->display_name}}</span>
                        <p>{{$team->description}}</p>
                        <div class="divider m-t-10 m-b-10"></div>
                            <blockquote class="m-b-0 m-t-5"><small>Created at - {{$team->created_at->format('Y-m-d')}}</small></blockquote>
                            <blockquote class="m-b-0 m-t-5"><small>Manager - {{$team->getOwner()->getShortName()}}</small></blockquote>
                            <blockquote class="m-b-0 m-t-5"><small>Count of students - {{count($team->getStudents())}}</small></blockquote>
                    </div>
                    <div class="card-action right-align">
                        <a href="{{url('/team/'.$team->name.'/edit')}}" class="indigo waves-effect waves-light btn-small right">Edit</a>
                        <a href="{{url('/team/'.$team->name)}}" class="indigo waves-effect waves-light btn-small right m-r-10">Open</a>
                    </div>
                </div>
            </div>
        @endforeach
        @if($teams->all() == null)
            <div class="row">
                <div class="col s12">
                    <div class="card-panel orange white-text">
                       <h5 class="center-align m-t-0 m-b-0-">Sorry, but you do not have any groups...</h5>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
