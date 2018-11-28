@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest-discipline', $team, $discipline) }}
@endsection
@section('content')
    <div class="row">
        @foreach($pretests as $pretest)
            <div class="col s12 m6">
                <div class="card hoverable">
                    <div class="card-content p-b-10 p-t-10">
                        <span class="card-title">{{$pretest->name}}</span>
                        <p class="m-b-10">{{$pretest->description}}</p>
                        @foreach($pretest->files as $file)
                            {!! Form::open(['route' => ['team.pretest.getFile', $file->file], 'method' => 'POST']) !!}
                            <button class="btn btn-small waves-effect waves-light indigo m-b-5" type="submit" name="action">{{$file->name}}
                                <i class="material-icons right">file_download</i>
                            </button>
                            {!! Form::close() !!}
                        @endforeach
                        <small><blockquote class="m-b-0 m-t-15">Start date - {{$pretest->start_date}}</blockquote></small>
                        <small><blockquote class="m-b-0 m-t-5">End date - {{$pretest->end_date}}</blockquote></small>
                    </div>
                    <div class="card-action right-align">
                        @role('student')
                            @if($pretest->isAvailable(Auth::user()->id))
                                <a href="{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id.'/pass')}}" class="indigo waves-effect waves-light btn-small right">Pass</a>
                            @else
                            <a class="waves-effect waves-light btn btn-small right disabled"><i class="material-icons right">lock</i>locked</a>
                            @endif
                        @endrole
                        @role('teacher')
                            <a href="{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id)}}" class="indigo waves-effect waves-light btn-small right">Open</a>
                        @endrole
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @role('teacher')
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <a href="{{url('/team/'.$team->name.'/pretest/create')}}" class="btn-floating btn-large green tooltipped" data-position="left"
           data-tooltip="Create Pretest">
            <i class="large material-icons">add</i>
        </a>
    </div>
    @endrole
@endsection
