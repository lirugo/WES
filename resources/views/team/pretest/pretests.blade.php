@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest-discipline', $team, $discipline) }}
@endsection
@section('content')
    <div class="row">
        @foreach($pretests as $pretest)
            <div class="col s12 m6">
                <div class="card hoverable">
                    <div class="card-content p-b-10 p-t-10">
                        <span class="card-title">{{$pretest->name}}</span>
                    </div>
                    <div class="card-action right-align">
                        @role('student')
                            <a href="{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id.'/pass')}}" class="indigo waves-effect waves-light btn-small right">Pass</a>
                        @endrole
                        @role('teacher')
                            <a href="{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id)}}" class="indigo waves-effect waves-light btn-small right">Open</a>
                        @endrole
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @role('teacher')
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <a href="{{url('/team/'.$team->name.'/pretest/create')}}" class="btn-floating btn-large green tooltipped" data-position="left"
           data-tooltip="Create Pretest">
            <i class="large material-icons">add</i>
        </a>
    </div>
    @endrole
@endsection
