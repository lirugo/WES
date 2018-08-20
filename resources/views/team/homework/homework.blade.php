@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-edit-homework-discipline-homework', $team, $discipline->getDiscipline, $homeWork) }}
@endsection
@section('content')
    {!! Form::open(['route' => ['team.homework.solution', $team->name, $discipline->getDiscipline->name, $homeWork->name], 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
    <div class="row">
        <div class="col s12">
            <div class="card hoverable">
                <div class="card-content">
                    <p class="right tooltipped" data-position="left" data-tooltip="Its Task"><i class="material-icons">help_outline</i></p>
                    <span class="card-title">{{$homeWork->display_name}}</span>
                    <p>{!!$homeWork->description!!}</p>
                    <small><blockquote>Created - {{$homeWork->created_at->format('Y-m-d H:i')}} ({{$homeWork->created_at->diffForHumans()}})</blockquote></small>
                    <small><blockquote>End date - {{Carbon\Carbon::parse($homeWork->assignment_date)->format('Y-m-d H:i')}} ({{Carbon\Carbon::parse($homeWork->assignment_date)->diffForHumans()}})</blockquote></small>
                    @if(count($homeWork->getFiles()) != 0)
                        <hr>
                        <div class="row">
                            @foreach($homeWork->getFiles() as $file)
                                <div class="col s6 m-t-5">
                                    <a href="{{url('/team/'.$team->name.'/homework/'.$discipline->getDiscipline->name.'/file/'.$file->name)}}" download class="valign-wrapper">
                                        <i class="material-icons m-r-5">cloud_download</i> Download *.{{pathinfo($file->name, PATHINFO_EXTENSION)}}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{--Solution--}}
    <div class="row">
        @foreach($homeWork->solutions as $solution)
            <div class="col s12 m6 l6">
                <div class="card hoverable">
                    <div class="card-content">
                        <p class="right tooltipped" data-position="right" data-tooltip="Its Solution"><i class="material-icons">priority_high</i></p>
                        <p class="right">{{$solution->owner->getShortName()}}</p>
                        <span class="card-title">{{$solution->display_name}}</span>
                        <p>{!!$solution->description!!}</p>
                        <small><blockquote>Created - {{$solution->created_at->format('Y-m-d H:i')}} ({{$solution->created_at->diffForHumans()}})</blockquote></small>
                        @if($solution->created_at != $solution->updated_at)
                            <small><blockquote>Updated - {{$solution->updated_at->format('Y-m-d H:i')}} ({{$solution->updated_at->diffForHumans()}})</blockquote></small>
                        @endif
                        @if(count($solution->getFiles()) != 0)
                            <hr>
                            <div class="row">
                                @foreach($solution->getFiles() as $file)
                                    <div class="col s6 m-t-5">
                                        <a href="{{url('/team/'.$team->name.'/homework/'.$discipline->getDiscipline->name.'/file/'.$file->name)}}" download class="valign-wrapper">
                                            <i class="material-icons m-r-5">cloud_download</i> Download *.{{pathinfo($file->name, PATHINFO_EXTENSION)}}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {!! Form::close() !!}
@endsection


@section('scripts')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey={{env('TINY_MC_KEY')}}"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime table contextmenu paste code help wordcount'
            ],
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css']
        });
    </script>
@endsection

