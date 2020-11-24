@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-video-lesson-show', $team, $teamDiscipline) }}
@endsection
@section('content')
    <div class="row">
        @foreach($videoLessons as $video)
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">{{$video->module}} #{{$video->part}}</span>
                        <p>{{$video->description}}</p>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Time'): {{$video->start_time}} - {{$video->end_time}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Date') - {{$video->date}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Created at') - {{$video->created_at->format('Y-m-d')}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Author') - {{$video->getOwner->getShortName()}}</small></blockquote>
                    </div>
                </div>
            </div>
        @endforeach
        @if($videoLessons == null)
            <div class="row">
                <div class="col s12">
                    <div class="card-panel orange white-text">
                        Dont have any video lessons yet...
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
