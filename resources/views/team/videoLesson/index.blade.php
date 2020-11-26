@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-video-lesson-show', $team, $teamDiscipline) }}
@endsection
@section('content')
    <div class="row">
        @foreach($videoLessons as $video)
            @if((Auth()->user()->hasRole(['student']) && $video->public ) || !Auth()->user()->hasRole(['student']))
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">{{$video->module}} #{{$video->part}}</span>

                        <div class="row m-b-0 m-t-0">
                            <div class="col s12 center">
                                <video controls preload="auto" src="{{url('/video-stream/'.$video->file_name)}}" width="100%"></video>
                            </div>
                        </div>

                        <p>{{$video->description}}</p>
                        <blockquote class="m-b-0 m-t-5"><small>{{$video->public ? 'Public' : 'Private'}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Time'): {{$video->start_time}} - {{$video->end_time}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Date') - {{$video->date}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Created at') - {{$video->created_at->format('Y-m-d')}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Author') - {{$video->getOwner->getShortName()}}</small></blockquote>

                        @role(['teacher', 'manager'])
                        {!! Form::open(['route' => ['team.video-lesson.delete', $team->name, $video->id], 'method' => 'DELETE']) !!}
                        <button type="submit" class="waves-effect waves-light btn btn-small red right"><i class="material-icons">delete</i></button>
                        {!! Form::close() !!}
                        @endrole
                    </div>
                </div>
            </div>
            @endif
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
