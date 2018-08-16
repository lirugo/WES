@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => ['team.homework.solution', $team->name, $discipline->getDiscipline->name, $homeWork->name], 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
    <div class="row">
        <div class="col s12 m6 l6">
            <div class="card hoverable">
                <div class="card-content">
                    @if($homeWork->file)
                        <a href="" class="right tooltipped attached-file" data-position="bottom" data-tooltip="Download attached file" download>
                            <i class="material-icons medium">attach_file</i>
                        </a>
                    @endif
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
        {{--Send Solution Form--}}
        @if($homeWork->getSolution() == null)
        <div class="col s12 m6 l6">
            <div class="card-panel hoverable" id="slug">
                <div class="input-field m-b-0 wr">
                    <i class="material-icons prefix">title</i>
                    {!! Form::text('display_name', null, ['class' => 'validate', 'id' => 'display_name', 'v-model' => 'title', 'required']) !!}
                    <label for="display_name">Title</label>
                </div>
                <div class="input-field">
                    <textarea name="description"></textarea>
                </div>
                <div class="input-field">
                    <div class="file-field">
                        <div class="btn indigo">
                            <span>File</span>
                            <input type="file" name="file[]" required multiple>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload files">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        {{--Solution--}}
        <div class="col s12 m6 l6">
            <div class="card hoverable">
                <div class="card-content">
                    @if($homeWork->file)
                        <a href="" class="right tooltipped attached-file" data-position="bottom" data-tooltip="Download attached file" download>
                            <i class="material-icons medium">attach_file</i>
                        </a>
                    @endif
                    <span class="card-title">{{$homeWork->getSolution()->display_name}}</span>
                    <p>{!!$homeWork->getSolution()->description!!}</p>
                    <small><blockquote>Created - {{$homeWork->getSolution()->created_at->format('Y-m-d H:i')}} ({{$homeWork->getSolution()->created_at->diffForHumans()}})</blockquote></small>
                    @if(count($homeWork->getSolution()->getFiles()) != 0)
                        <hr>
                        <div class="row">
                            @foreach($homeWork->getSolution()->getFiles() as $file)
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
        @endif
    </div>


    {{--Floating button--}}
    <div class="fixed-action-btn">
        <button type="submit" class="btn-floating btn-large green tooltipped" data-position="left" data-tooltip="Send My Solution">
            <i class="large material-icons">save</i>
        </button>
        <ul>
            <li><a class="btn-floating red tooltipped" data-position="left" data-tooltip="Go Back" href="{{url('/team/'.$team->name.'/homework/'.$discipline->getDiscipline->name)}}"><i class="material-icons">close</i></a></li>
        </ul>
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

