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
                            <span data-badge-caption="" class="new badge orange left">@lang('app.Max') {{$activity->max_mark}} @lang('app.balls')</span>
                        @endif
                        @role('student')
                        @if($activity->getMark(auth()->id()))
                            <span data-badge-caption="" class="new badge red right">@lang('app.Your mark') {{$activity->getMark(auth()->id())->mark}}</span>
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
                        @if(Auth()->user()->hasRole(['manager','teacher']))
                            <form action="{{ url('team/'.$team->name.'/activity/'.$discipline->name.'/pass/'.$activity->id.'/update')}}" method="POST">
                                @csrf
                                <div class="row m-b-0">
                                    {{--Start date&time picker--}}
                                    <div class="input-field col s12 m6 l6 p-b-0 m-b-0">
                                        <i class="material-icons prefix">date_range</i>
                                        <input id="start_date" value="{{ \Carbon\Carbon::parse($activity->start_date)->format('Y-m-d') }}" name="start_date" type="text" class="datepickerDefault" required>
                                        <label for="start_date">@lang('app.Start date')</label>
                                    </div>
                                    <div class="input-field col s12 m6 l6 p-b-0 m-b-0">
                                        <i class="material-icons prefix">access_time</i>
                                        <input id="start_time" value="{{ \Carbon\Carbon::parse($activity->start_date)->format('H:i') }}" name="start_time" type="text" class="timepicker" required>
                                        <label for="start_time">@lang('app.Start Time')</label>
                                    </div>
                                    {{--End date&time picker--}}
                                    <div class="input-field col s12 m6 l6 p-b-0 m-b-0">
                                        <i class="material-icons prefix">date_range</i>
                                        <input id="end_date" value="{{ \Carbon\Carbon::parse($activity->end_date)->format('Y-m-d') }}" name="end_date" type="text" class="datepickerDefault" required>
                                        <label for="end_date">@lang('app.End date')</label>
                                    </div>
                                    <div class="input-field col s12 m6 l6 p-b-0 m-b-0">
                                        <i class="material-icons prefix">access_time</i>
                                        <input id="end_time" value="{{ \Carbon\Carbon::parse($activity->end_date)->format('H:i') }}" name="end_time" type="text" class="timepicker" required>
                                        <label for="end_time">@lang('app.End Time')</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-small orange">@lang('app.Update')</button>
                            </form>
                        @else
                            <small><blockquote class="m-b-0 m-t-15">@lang('app.Start date') - {{$activity->start_date}}</blockquote></small>
                            <small><blockquote class="m-b-0 m-t-5">@lang('app.End date') - {{$activity->end_date}}</blockquote></small>
                        @endif
                    </div>
                    <div class="card-action p-l-0">
                        @role(['teacher', 'manager'])
                        {!! Form::open(['route' => ['team.activity.delete', $activity->id], 'method' => 'POST']) !!}
                        <button type="submit" class="waves-effect waves-light btn btn-small red right"><i class="material-icons">delete</i></button>
                        {!! Form::close() !!}

                        <a href="{{ url('team/'.$team->name.'/activity/'.$discipline->name.'/pass/'.$activity->id.'/students') }}" class="btn btn-small indigo left m-l-20 waves-effect waves-light">@lang('app.Students')</a>
                        @endrole
                        @role('student')
                        @if($activity->start_date < now())
                            <a href="{{ url('team/'.$team->name.'/activity/'.$discipline->name.'/pass/'.$activity->id.'/'.Auth::user()->id) }}" class="btn btn-small indigo right waves-effect waves-light">@lang('app.Open')</a>
                        @else
                            <a class="btn btn-small red right waves-effect waves-light" disabled="">Not active yet...</a>
                        @endif
                        @endrole
                    </div>
                </div>
            </div>
        @endforeach

        @role(['teacher', 'manager'])
        {{--Link create page--}}
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large waves-effect waves-light green" href="{{url('team/'.$team->name.'/activity/create')}}"><i class="material-icons">add</i></a>
        </div>
        @endrole
    </div>
@endsection
