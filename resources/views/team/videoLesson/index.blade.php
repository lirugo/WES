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
                        {{$video}}
{{--                        <span class="card-title center-align">{{$video->display_name}}</span>--}}
{{--                        <p>{{$video->description}}</p>--}}
{{--                        <div class="divider m-t-10 m-b-10"></div>--}}
{{--                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Created at') - {{$video->created_at->format('Y-m-d')}}</small></blockquote>--}}
{{--                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Manager') - {{$video->getOwner()->getShortName()}}</small></blockquote>--}}
{{--                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Count of students') - {{count($video->getStudents())}}</small></blockquote>--}}
                    </div>
                    <div class="card-action right-align">
                        <a href="{{url('/team/'.$team->name.'/video-lesson/'.$teamDiscipline->id)}}" class="indigo waves-effect waves-light btn-small right">@lang('app.Open')</a>
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
