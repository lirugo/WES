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
                    <div class="card-content p-b-0">
                        @if($homeWork->file)
                            <a href="" class="right tooltipped attached-file" data-position="bottom" data-tooltip="Download attached file" download>
                                <i class="material-icons medium">attach_file</i>
                            </a>
                        @endif
                        <span class="card-title">{{$homeWork->display_name}}</span>
                        <p>{!!$homeWork->description!!}</p>
                        <blockquote>Created - {{$homeWork->created_at->format('Y-m-d H:i')}} ({{$homeWork->created_at->diffForHumans()}})</blockquote>
                        <blockquote>End date - {{Carbon\Carbon::parse($homeWork->assignment_date)->format('Y-m-d H:i')}} ({{Carbon\Carbon::parse($homeWork->assignment_date)->diffForHumans()}})</blockquote>
                            @if(count($homeWork->getFiles) != 0)
                        <hr>
                        <div class="row">
                            @foreach($homeWork->getFiles as $file)
                                <div class="col s6 m-t-5">
                                    <a href="{{url('/team/'.$team->name.'/homework/'.$discipline->getDiscipline->name.'/file/'.$file->name)}}" download class="valign-wrapper">
                                        <i class="material-icons m-r-5">cloud_download</i> Download *.{{pathinfo($file->name, PATHINFO_EXTENSION)}}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                            @endif
                    </div>
                    <div class="card-action right-align">
                        <a href="#" class="indigo waves-effect waves-light btn-small right">Send Solution</a>
                        <a href="#" class="indigo waves-effect waves-light btn-small right m-r-10">Show My Solution</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{--Floating button--}}
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large red">
            <i class="large material-icons">mode_edit</i>
        </a>
        <ul>
            <li><a class="btn-floating green tooltipped" data-position="left" data-tooltip="Set Home Work" href="{{url('/team/'.$team->name.'/homework/'.$discipline->getDiscipline->name.'/create')}}"><i class="material-icons">add</i></a></li>
        </ul>
    </div>
@endsection
