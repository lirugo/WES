@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-activity', $team) }}
@endsection
@section('content')
    {{--Show type activity--}}
    <div class="row">
        @foreach($team->getStudents() as $student)
            <div class="col s12 m4">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">{{$student->getShortName()}}</span>
                    </div>
                    <div class="card-action">
                        <a href="{{url('team/'.$team->name.'/activity/'.$discipline->name.'/pass/'.$activity->id.'/'.$student->id)}}" class=" waves-effect waves-light btn-small right indigo">Open</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection