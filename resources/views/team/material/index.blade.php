@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-material', $team) }}
@endsection
@section('content')
    <div class="row">
        @foreach($disciplines as $discipline)
            @if($discipline->hasPretest())
                <div class="col s12 m6">
                    <div class="card hoverable">
                        <div class="card-content">
                            <span class="card-title center-align">Pretest - {{$discipline->getDiscipline->display_name}}</span>
                            <p>{{$discipline->getDiscipline->description}}</p>
                        </div>
                        <div class="card-action right-align">
                            <a href="{{url('/team/'.$team->name.'/material/'.$discipline->getDiscipline->name)}}" class="indigo waves-effect waves-light btn-small right">Open</a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
    @role('teacher')
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <a href="{{url('/team/'.$team->name.'/material/create')}}" class="btn-floating btn-large green tooltipped" data-position="left"
           data-tooltip="Upload Material">
            <i class="large material-icons">add</i>
        </a>
    </div>
    @endrole
@endsection
