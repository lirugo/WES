@extends('layouts.app')

@section('content')
    {{--Header--}}
    <div class="row">
        <div class="col s12">
            <div class="card hoverable">
                <div class="card-content">
                    <div class="row m-b-0">
                        <div class="col s12">
                            <span class="card-title center-align">Home Work - {{$discipline->getDiscipline->display_name}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($discipline->getHomeWork() as $homeWork)
            <div class="col s12 m6 l6">
                <div class="card hoverable">
                    <div class="card-content">
                        @if($homeWork->file)
                            <a href="/manage" class="right tooltipped attached-file" data-position="bottom" data-tooltip="Download attached file">
                                <i class="material-icons medium">attach_file</i>
                            </a>
                        @endif
                        <span class="card-title">{{$homeWork->display_name}}</span>
                        <p>{!!$homeWork->description!!}</p>
                        <blockquote>Created - {{$homeWork->created_at->format('Y-m-d H:i')}} ({{$homeWork->created_at->diffForHumans()}})</blockquote>
                        <blockquote>End date - {{Carbon\Carbon::parse($homeWork->assignment_date)->format('Y-m-d H:i')}} ({{Carbon\Carbon::parse($homeWork->assignment_date)->diffForHumans()}})</blockquote>
                    </div>
                    <div class="card-action right-align">
                        {{--<a href="{{url('/team/'.$team->name.'/edit')}}" class="indigo waves-effect waves-light btn-small right">Edit</a>--}}
                        {{--<a href="{{url('/team/'.$team->name)}}" class="indigo waves-effect waves-light btn-small right m-r-10">Open</a>--}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
