@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-mark', $team) }}
@endsection
@section('content')
    <div class="row">
        @foreach($disciplines as $discipline)
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content">
                        <span class="card-title">{{$discipline->getDiscipline->display_name}}</span>
                        <p>{{$discipline->getDiscipline->description}}</p>
                    </div>
                    <div class="card-action right-align">
                        <a href="{{url('/team/'.$team->name.'/mark/'.$discipline->getDiscipline->name)}}" class="indigo-text">Open</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
