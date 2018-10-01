@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-show-homework-discipline-homework', $team, $discipline->getDiscipline, $homeWork) }}
@endsection
@section('content')
   <div class="row">
       @if(Auth::user()->hasRole(['administrator', 'top-manager', 'manager', 'teacher']))
           <div class="col s12">
               <div class="card hoverable">
                   <div class="card-content">
                       {!! Form::open(['route' => ['team.homework.update',$team->name, $discipline->getDiscipline->name, $homeWork->name], 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
                       <div class="input-field m-b-0">
                           <i class="material-icons prefix">title</i>
                           {!! Form::text('display_name', $homeWork->display_name, ['class' => 'validate', 'name' => 'display_name', 'id' => 'display_name', 'v-model' => 'title', 'required']) !!}
                           <label for="display_name">Display Name</label>
                       </div>
                       <widget-slug url="{{url('/')}}" subdirectory="/team/{{$team->name}}/homework/{{$discipline->getDiscipline->name}}/" :title="title"></widget-slug>
                       <div class="input-field">
                           <textarea name="description">{{$homeWork->description}}</textarea>
                       </div>
                       <div class="row">
                           @if(count($homeWork->getFilesTask()) != 0)
                               <div class="row">
                                   @foreach($homeWork->getFilesTask() as $file)
                                       <div class="input-field col s3 m-t-5 m-b-0">
                                           <a href="{{url('/team/'.$team->name.'/homework/'.$discipline->getDiscipline->name.'/file/'.$file->name)}}" download class="valign-wrapper">
                                               <i class="material-icons m-r-5">cloud_download</i> Download *.{{pathinfo($file->name, PATHINFO_EXTENSION)}}
                                           </a>
                                       </div>
                                   @endforeach
                               </div>
                           @endif
                           <div class="input-field col s12 m4 l4">
                               <div class="file-field">
                                   <div class="btn indigo">
                                       <span>File</span>
                                       <input type="file" name="file[]" multiple>
                                   </div>
                                   <div class="file-path-wrapper">
                                       <input class="file-path validate" type="text" placeholder="Update files">
                                   </div>
                               </div>
                           </div>
                           {{--End date&time picker--}}
                           <div class="input-field col s12 m4 l4">
                               <i class="material-icons prefix">date_range</i>
                               <input id="end_date" value="{{Carbon\Carbon::parse($homeWork->assignment_date)->format('Y-m-d')}}" name="end_date" type="text" class="datepickerDefault" required>
                               <label for="end_date">End Date Assignment</label>
                           </div>
                           <div class="input-field col s12 m4 l4">
                               <i class="material-icons prefix">access_time</i>
                               <input id="end_time" value="{{Carbon\Carbon::parse($homeWork->assignment_date)->format('H:i')}}" name="end_time" type="text" class="timepicker" required>
                               <label for="end_time">End Time Assignment</label>
                           </div>
                       </div>
                       {{--Floating button--}}
                       <div class="fixed-action-btn">
                           <button type="submit" class="btn-floating btn-large yellow darken-3 tooltipped" data-position="left" data-tooltip="Update">
                               <i class="large material-icons">cloud</i>
                           </button>
                       </div>
                       {!! Form::close() !!}
                   </div>
               </div>
           </div>
       @else
           <div class="col s12">
               <div class="card hoverable">
                   <div class="card-content">
                       <p class="right tooltipped" data-position="left" data-tooltip="Its Task"><i class="material-icons">help_outline</i></p>
                       <span class="card-title">{{$homeWork->display_name}}</span>
                       <p>{!!$homeWork->description!!}</p>
                       <small><blockquote>Created - {{$homeWork->created_at->format('Y-m-d H:i')}} ({{$homeWork->created_at->diffForHumans()}})</blockquote></small>
                       <small><blockquote>End date - {{Carbon\Carbon::parse($homeWork->assignment_date)->format('Y-m-d H:i')}} ({{Carbon\Carbon::parse($homeWork->assignment_date)->diffForHumans()}})</blockquote></small>
                       @if(count($homeWork->getFilesTask()) != 0)
                           <hr>
                           <div class="row">
                               @foreach($homeWork->getFilesTask() as $file)
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

    @if(Auth::user()->hasRole(['administrator', 'top-manager', 'manager', 'teacher']))
    {{--Solutions--}}
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
                        @if(count($solution->getFilesSolution($solution->student_id)) != 0)
                            <hr>
                            <div class="row">
                                @foreach($solution->getFilesSolution($solution->student_id) as $file)
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
    @elseif(Auth::user()->hasRole('student'))
        <div class="row">
            @if($homeWork->getSolution() == null)
                {!! Form::open(['route' => ['team.homework.solution', $team->name, $discipline->getDiscipline->name, $homeWork->name], 'enctype' => 'multipart/form-data', 'method' => 'POST']) !!}
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
                {{--Floating button--}}
                <div class="fixed-action-btn">
                    <button type="submit" class="btn-floating btn-large green tooltipped" data-position="left" data-tooltip="Send My Solution">
                        <i class="large material-icons">save</i>
                    </button>
                </div>
                {!! Form::close() !!}
            @else
                {{--Solution--}}
                <div class="col s12 m6 l6">
                    <div class="card hoverable">
                        <div class="card-content">
                            <p class="right tooltipped" data-position="left" data-tooltip="Its My Solution"><i class="material-icons">priority_high</i></p>
                            <span class="card-title">{{$homeWork->getSolution()->display_name}}</span>
                            <p>{!!$homeWork->getSolution()->description!!}</p>
                            <small><blockquote>Created - {{$homeWork->getSolution()->created_at->format('Y-m-d H:i')}} ({{$homeWork->getSolution()->created_at->diffForHumans()}})</blockquote></small>
                            @if($homeWork->getSolution()->created_at != $homeWork->getSolution()->updated_at)
                                <small><blockquote>Updated - {{$homeWork->getSolution()->updated_at->format('Y-m-d H:i')}} ({{$homeWork->getSolution()->updated_at->diffForHumans()}})</blockquote></small>
                            @endif
                            @if(count($homeWork->getSolution()->getFilesSolution($homeWork->getSolution()->student_id)) != 0)
                                <hr>
                                <div class="row">
                                    @foreach($homeWork->getSolution()->getFilesSolution($homeWork->getSolution()->student_id) as $file)
                                        <div class="col s6 m-t-5">
                                            <a href="{{url('/team/'.$team->name.'/homework/'.$discipline->getDiscipline->name.'/file/'.$file->name)}}" download class="valign-wrapper">
                                                <i class="material-icons m-r-5">cloud_download</i> Download *.{{pathinfo($file->name, PATHINFO_EXTENSION)}}
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @if($homeWork->assignment_date > \Carbon\Carbon::now())
                            {{--Floating button--}}
                                <div class="fixed-action-btn">
                                    <a class="btn-floating btn-large red tooltipped" data-position="left" data-tooltip="Edit My Solution"
                                       href="{{url('/team/'.$team->name.'/homework/'.$discipline->getDiscipline->name.'/'.$homeWork->name.'/solution/edit')}}">
                                        <i class="large material-icons">edit</i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
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

