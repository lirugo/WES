@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-activity-show-students', $team, $discipline, $activity) }}
@endsection
@section('content')
    {{--Show type activity--}}
    <div class="row">
        @foreach($team->getStudents() as $student)
            <div class="col s12 m4">
                <div class="card hoverable">
                    @if($activity->getMark($student->id))
                        <span data-badge-caption="" class="new badge grey right">Mark {{$activity->getMark($student->id) ? $activity->getMark($student->id)->mark : ''}}</span>
                    @else
                        <span data-badge-caption="" class="new badge orange right">No mark</span>
                    @endif
                    <div class="card-content">
                        <span class="card-title center-align">{{$student->getFullName()}}</span>

                    </div>
                    <div class="card-action">
                        <a href="{{url('team/'.$team->name.'/activity/'.$discipline->name.'/pass/'.$activity->id.'/'.$student->id)}}" class=" waves-effect waves-light btn-small right indigo">@lang('app.Open')</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection