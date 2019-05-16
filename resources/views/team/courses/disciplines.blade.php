@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-courses', $team) }}
@endsection
@section('content')
    {{--Show type activity--}}
    <div class="row">
        @foreach($disciplines as $discipline)
            <div class="col s12 m6">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">{{$discipline->getDiscipline->display_name}}</span>
                    </div>
                    <div class="card-action">
                        <a href="{{url('team/'.$team->name.'/courses/'.$discipline->getDiscipline->name)}}" class=" waves-effect waves-light btn-small right indigo">Open</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
