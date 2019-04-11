@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-activity-show', $team, $discipline) }}
@endsection
@section('content')
    {{--Show type activity--}}
    <div class="row">
        @foreach($activities as $activity)
            <div class="col s12 m6">
                <div class="card hoverable">
                    <div>
                        <span data-badge-caption="" class="new badge left m-l-0">{{$activity->getType()}}</span>
                        @if($activity->mark_in_journal)
                            <span data-badge-caption="" class="new badge orange left">Max {{$activity->max_mark}} balls</span>
                        @endif
                        @role('student')
                            @if($activity->getMark(auth()->id()))
                                <span data-badge-caption="" class="new badge red right">Your mark {{$activity->getMark(auth()->id())->mark}}</span>
                            @endif
                        @endrole
                    </div>
                    <div class="card-content">
                        <p class="card-title m-b-0">{{$activity->name}}</p>
                        @if($activity->type == 'other')
                            <span><small>{{$activity->type_name}}</small></span>
                        @endif
                        <p>{!! $activity->description !!}</p>
                        <div class="m-t-10">
                            @if(count($activity->files))
                                @foreach($activity->files as $file)
                                    {!! Form::open(['route' => ['team.activity.getFile', $file->file], 'method' => 'POST']) !!}
                                    <button class="btn btn-small waves-effect waves-light indigo m-b-5" type="submit" name="action">{{$file->name}}
                                        <i class="material-icons right">file_download</i>
                                    </button>
                                    {!! Form::close() !!}
                                @endforeach
                            @endif
                        </div>
                        <small><blockquote class="m-b-0 m-t-15">Start date - {{$activity->start_date}}</blockquote></small>
                        <small><blockquote class="m-b-0 m-t-5">End date - {{$activity->end_date}}</blockquote></small>
                    </div>
                    <div class="card-action p-l-0">
                        @role(['teacher', 'manager'])
                            <a href="{{ url('team/'.$team->name.'/activity/'.$discipline->name.'/pass/'.$activity->id.'/students') }}" class="btn btn-small indigo right waves-effect waves-light">Students</a>
                        @endrole
                        @role('student')
                            @if($activity->isOpen())
                                <a href="{{ url('team/'.$team->name.'/activity/'.$discipline->name.'/pass/'.$activity->id.'/'.Auth::user()->id) }}" class="btn btn-small indigo right waves-effect waves-light">Open</a>
                            @endif
                        @endrole
                    </div>
                </div>
            </div>
        @endforeach

        @role('teacher')
        {{--Link create page--}}
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large waves-effect waves-light green" href="{{url('team/'.$team->name.'/activity/create')}}"><i class="material-icons">add</i></a>
        </div>
        @endrole
    </div>
@endsection
