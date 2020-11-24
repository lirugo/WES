@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-video-lesson', $team) }}
@endsection
@section('content')
    {{--Show type group work--}}
    <div class="row">
        @foreach($disciplines as $discipline)
            <div class="col s12 m6">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">{{$discipline->getDiscipline->display_name}}</span>
                    </div>
                    <div class="card-action">
                        <a href="{{url('/team/'.$team->name.'/video-lesson/'.$discipline->id)}}" class=" waves-effect waves-light btn-small right indigo">@lang('app.Open')</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="fixed-action-btn">
        <a class="btn-floating btn-large green" href="{{url('/team/'.$team->name.'/video-lesson/create')}}">
            <i class="large material-icons">add</i>
        </a>
    </div>
@endsection