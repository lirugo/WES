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

                            {!! Form::open(['route' => ['team.video-lesson.update', $team->name, $video->id], 'method' => 'UPDATE']) !!}
                            <div class="input-field col s8 p-b-0 m-b-0">
                                <input id="module" value="{{$video->module}}" name="module" type="text" required {{Auth()->user()->hasRole(['student']) ? 'disabled' : ''}}>
                                <label>Module</label>
                            </div>
                            <div class="input-field col s4 p-b-0 m-b-0">
                                <input id="part" value="{{$video->part}}" name="part" type="number" min="1" max="10" {{Auth()->user()->hasRole(['student']) ? 'disabled' : ''}} required>
                                <label>Part</label>
                            </div>

                            <div class="input-field col s6 m6 l6 p-b-0 m-b-0">
                                <i class="material-icons prefix">access_time</i>
                                <input id="start_time" {{Auth()->user()->hasRole(['student']) ? 'disabled' : ''}} value="{{ \Carbon\Carbon::parse($video->start_time)->format('H:i') }}" name="start_time" type="text" class="timepicker" required>
                                <label for="start_time">@lang('app.Start Time')</label>
                            </div>

                            <div class="input-field col s6 m6 l6 p-b-0 m-b-0">
                                <i class="material-icons prefix">access_time</i>
                                <input id="end_time" {{Auth()->user()->hasRole(['student']) ? 'disabled' : ''}} value="{{ \Carbon\Carbon::parse($video->end_time)->format('H:i') }}" name="end_time" type="text" class="timepicker" required>
                                <label for="end_time">@lang('app.End Time')</label>
                            </div>

                            <div class="input-field col s12 l6 p-b-0">
                                <input disabled/>
                                <label>
                                    <input type="checkbox" name="public" {{Auth()->user()->hasRole(['student']) ? 'disabled' : ''}} {{$video->public ? 'checked' : ''}} />
                                    <span>@lang('app.Public')</span>
                                </label>
                            </div>

                            <div class="row m-b-0 m-t-0">
                                <div class="col s12 center">
                                    <video controls preload="auto" src="{{url('/video-stream/'.$video->file_name)}}" width="100%"></video>
                                </div>
                            </div>

                            <p>{{$video->description}}</p>
                            <blockquote class="m-b-0 m-t-5"><small>@lang('app.Time'): {{$video->start_time}} - {{$video->end_time}}</small></blockquote>
                            <blockquote class="m-b-0 m-t-5"><small>@lang('app.Date') - {{$video->date}}</small></blockquote>
                            <blockquote class="m-b-0 m-t-5"><small>@lang('app.Created at') - {{$video->created_at->format('Y-m-d')}}</small></blockquote>
                            <blockquote class="m-b-0 m-t-5"><small>@lang('app.Author') - {{$video->getOwner->getShortName()}}</small></blockquote>


                            @role(['teacher', 'manager'])
                            <button type="submit" class="waves-effect waves-light btn btn-small orange m-l-5 right"><i class="material-icons">update</i></button>
                            @endrole

                            {!! Form::close() !!}

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
