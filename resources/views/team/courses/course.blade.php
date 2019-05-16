@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-courses-course', $team, $discipline) }}
@endsection
@section('content')
    {{--Show type activity--}}
    <div class="row">
{{--        All activity--}}
        <div class="col s12">
            <ul class="collection with-header hoverable">
                <li class="collection-header"><h4>Activities</h4></li>
                <div class="collection m-t-0 m-b-0">
                    @if(count($teamDiscipline->getActivities) <= 0)
                        <a href="#" class="collection-item disabled">
                            No content yet...
                        </a>
                    @endif
                    @foreach($teamDiscipline->getActivities as $activity)
                        <a href="{{ url('team/'.$team->name.'/activity/'.$discipline->name.'/pass/'.$activity->id.'/'.Auth::user()->id) }}" class="collection-item">
                            {{$activity->name}}
                            <i class="material-icons right">send</i>
                        </a>
                    @endforeach
                </div>
            </ul>
        </div>
{{--        All Pretests--}}
        <div class="col s12">
            <ul class="collection with-header hoverable">
                <li class="collection-header"><h4>Pretests</h4></li>
                <div class="collection m-t-0 m-b-0">
                    @if(count($teamDiscipline->pretests) <= 0)
                        <a href="#" class="collection-item disabled">
                            No content yet...
                        </a>
                    @endif
                    @foreach($teamDiscipline->pretests as $pretest)
                        <a href="{{ url('team/'.$team->name.'/pretest/discipline/'.$discipline->name) }}" class="collection-item">
                            {{$pretest->name}}
                            <i class="material-icons right">send</i>
                        </a>
                    @endforeach
                </div>
            </ul>
        </div>
{{--        All Group Work--}}
        <div class="col s12">
            <ul class="collection with-header hoverable">
                <li class="collection-header"><h4>Group Works</h4></li>
                <div class="collection m-t-0 m-b-0">
                    @if(count($groupWorks) <= 0)
                        <a href="#" class="collection-item disabled">
                            No content yet...
                        </a>
                    @endif
                    @foreach($groupWorks as $work)
                        <a href="{{ url('team/'.$team->name.'/group-work/'.$discipline->name.'/'.$work->id) }}" class="collection-item">
                            {{$work->name}}
                            <i class="material-icons right">send</i>
                        </a>
                    @endforeach
                </div>
            </ul>
        </div>
    </div>
@endsection
