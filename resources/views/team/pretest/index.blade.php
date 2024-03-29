@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest', $team) }}
@endsection
@section('content')
    <div class="row">
        @foreach($disciplines as $discipline)
            <div class="col s12 m6">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">@lang('app.Pretest') - {{$discipline->getDiscipline->display_name}}</span>
                        <p>{{$discipline->getDiscipline->description}}</p>
                    </div>
                    <div class="card-action right-align">
                        <a href="{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->getDiscipline->name)}}" class="indigo waves-effect waves-light btn-small right">@lang('app.Open')</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @role('teacher')
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <a href="{{url('/team/'.$team->name.'/pretest/create')}}" class="btn-floating btn-large green tooltipped" data-position="left"
           data-tooltip="@lang('app.Create Pretest')">
            <i class="large material-icons">add</i>
        </a>
    </div>
    @endrole
@endsection
