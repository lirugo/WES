@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-show', $team) }}
@endsection
@section('content')
    <div id="team-dashboard">
        {{--Name and Manager block--}}
        <div class="row">
            {!! Form::open(['route' => ['team.update', $team->name], 'method' => 'POST']) !!}
            <div class="col s12 l6">
                <div class="card-panel hoverable">
                    <div class="input-field">
                        <i class="material-icons prefix">attachment</i>
                        {!! Form::text('name', $team->name, ['class' => 'validate', 'id' => 'name', 'required', 'disabled']) !!}
                        <label for="name">@lang('app.Name')</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">group</i>
                        {!! Form::text('display_name', $team->display_name, ['class' => 'validate', 'id' => 'display_name', 'required']) !!}
                        <label for="display_name">@lang('app.Displaying Name')</label>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">format_align_justify</i>
                        {!! Form::textarea('description', $team->description, ['class' => 'validate materialize-textarea', 'id' => 'description', 'required']) !!}
                        <label for="description">@lang('app.Description')</label>
                    </div>
                    @role('manager')
                    <div class="input-field">
                        <input disabled/>
                        <label>
                            <input type="checkbox" name="video_lessons" {{$team->video_lessons ? 'checked' : ''}} />
                            <span>@lang('app.Video Lessons')</span>
                        </label>
                    </div>
                    <button type="submit" class="yellow darken-4 waves-effect waves-light btn"><i class="material-icons right">update</i>@lang('app.Update')</button>
                    @endrole
                </div>
            </div>
            {!! Form::close() !!}
            <div class="col s12 l6">
                <div class="s12">
                    <div class="card-panel indigo white-text m-b-0">
                        <h6 class="card-title m-t-0 m-b-0 center-align">@lang('app.Manager of this group.')</h6>
                    </div>
                </div>
                <div class="s12">
                    <div class="card-panel hoverable">
                        <a href="#user"><img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$team->getOwner()->avatar)}}"></a>
                        <p class="card-title m-b-0">{{$team->getOwner()->getFullName()}}</p>
                        <p class="card-title m-t-0 m-b-0">{{$team->getOwner()->email}}</p>
                        <p class="card-title m-t-0">{{$team->getOwner()->getPhone()}}</p>
                        <a class="indigo waves-effect waves-light btn-small right"><i class="material-icons right">message</i>@lang('app.Have question?')</a>
                    </div>
                </div>
            </div>
            <div class="col s12 l6 m-b-0 m-t-0">
                <div class="card-panel hoverable m-b-0 m-t-0">
                    <div class="row m-b-0 m-t-0">
                        @foreach($team->lessonsTime as $time)
                            <div class="input-field col s6 m4 m-b-0 m-t-0">
                                <input type="text" value="{{\Carbon\Carbon::parse($time->start_time)->format('H:i')}} - {{\Carbon\Carbon::parse($time->end_time)->format('H:i')}}" disabled>
                                <span class="helper-text" data-error="wrong" data-success="right">@lang('app.Lecture') {{$time->position}}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <div class="card-panel indigo white-text m-b-0">
                    <h6 class="card-title m-t-0 m-b-0 center-align">@lang('app.Common files')</h6>
                </div>
            </div>
            <div class="col s12">
                <div class="card-panel m-b-0">
                    @if(count($team->commonFiles) == 0)
                        <small>@lang('app.No any common file yet...')</small>
                    @endif
                    @foreach($team->commonFiles as $file)
                        <a href="{{url('/team/'.$team->name.'/common/file/'.$file->file)}}" class="waves-effect waves-light btn indigo m-b-5">
                            {{$file->title}}
                            <i class="material-icons right">file_download</i>
                        </a>
                        @role('manager')
                            <button @click="removeCommonFile('{{ $file->file }}')" class="waves-effect waves-light btn red darken-1 m-b-5 m-r-10">
                                <i class="material-icons">close</i>
                            </button>
                        @endrole
                    @endforeach
                </div>
            </div>
        </div>
        {{--Display students of this group--}}
        <div class="row">
            <div class="col s12">
                <div class="card-panel indigo white-text m-b-0">
                    <h6 class="card-title m-t-0 m-b-0 center-align">@lang('app.Students of this group')</h6>
                </div>
            </div>
            @foreach($team->getStudents() as $student)
                <div class="col s12 l6">
                    <div class="card-panel hoverable">
                        @if(Auth::user()->hasRole('manager'))
                            <div class="right">
                                @if(!$team->isHeadman($student->id))
                                    {!! Form::open(['route' => ['team.setHeadman', $team->name], 'method' => 'POST', 'id' => 'headman-form']) !!}
                                    <button type="submit" data-position="left" data-tooltip="@lang('app.Set like a headman')" class="waves-effect waves-light btn btn-small indigo tooltipped"><i class="material-icons">add_circle_outline</i></button>
                                    <input type="hidden" name="student_id" value="{{$student->id}}"/>
                                    {!! Form::close() !!}
                                @endif
                            </div>
                        @endif
                        <a href="#user">
                            @if($team->isHeadman($student->id))
                                <img src="{{asset('/images/icon/teams/headman_en.png')}}" class="left" style="position: absolute; margin: -15px 0 0 -10px;" width="50px"/>
                            @endif
                            <img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$student->avatar)}}">
                        </a>
                        <p class="card-title m-t-0 m-b-0">{{$student->getFullName()}}</p>
                        <p class="card-title m-t-0 m-b-0">{{$student->email}}</p>
                        <p class="card-title m-t-0 m-b-0">{{$student->getPhone()}}</p>
                        @if(Auth::user()->hasRole(['administrator', 'top-manager', 'manager', 'teacher']))
                            <p class="card-title m-t-0">{{$student->getCountOfYear()}} years old</p>
                        @endif
                        @if(Auth::user()->hasRole(['administrator', 'top-manager', 'manager']))
                            {!! Form::open(['route' => ['team.student.delete', $team->id, $student->id]]) !!}
                            <button type="submit" class="red darken-1 waves-effect waves-light btn btn-small"><i class="material-icons">delete</i></button>
                            <a href="{{url('/student',$student->id)}}" class="indigo waves-effect waves-light btn btn-small right"><i class="material-icons">open_in_new</i></a>
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{--Display discipline of this group--}}
        <div class="row">
            <div class="col s12">
                <div class="card-panel indigo white-text m-b-0">
                    <h6 class="card-title m-t-0 m-b-0 center-align">@lang('app.Disciplines of this group')</h6>
                </div>
            </div>
            @foreach($team->disciplinesAsc() as $discipline)
                @if(Auth::user()->hasRole('student') && !$discipline->disabled || !Auth::user()->hasRole('student'))
                    <div class="col s12 l6">
                        <div class="card-panel {{$discipline->disabled ? 'card-disabled' : 'hoverable'}}">
                            <blockquote class="m-t-0">{{$discipline->getDiscipline->display_name}}</blockquote>
                            <a href="#user"><img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$discipline->getTeacher->avatar)}}"></a>
                            <p class="card-title m-t-10 m-b-0">{{$discipline->getTeacher->getFullName()}}</p>
                            <p class="card-title m-t-0 m-b-0">{{$discipline->getTeacher->email}}</p>
                            <p class="card-title m-t-0 m-b-0">{{$discipline->getTeacher->getPhone()}}</p>
                            <p class="card-title m-t-0 m-b-0">Hours - {{$discipline->hours}}</p>
                            @if(Auth::user()->hasRole(['top-manager', 'manager', 'teacher']))
                                <p class="card-title m-t-0">{{$discipline->getTeacher->getCountOfYear()}} years old</p>
                            @endif
                            {{--Actions with discipline--}}
                            @if(Auth::user()->hasRole('manager'))
                                <form action="{{url('/team/'.$team->name.'/discipline/'.$discipline->id.'/disable')}}" method="POST">
                                    @csrf
                                    @if($discipline->disabled)
                                        <button type="submit" class="waves-effect waves-light btn btn-small red" ><i class="material-icons right">add</i>@lang('app.enable')</button>
                                    @else
                                        <button type="submit" class="waves-effect waves-light btn btn-small red" ><i class="material-icons right">close</i>@lang('app.disable')</button>
                                    @endif
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        @if(Auth::user()->hasRole(['administrator', 'top-manage', 'manager']))
            <div class="row">
                <div class="col s12 m6 l4">
                    {{--Add new student--}}
                    <div class="card-panel hoverable">
                        {!! Form::open(['route' => ['team.student.store',$team->name], 'method' => 'POST']) !!}
                        <h5 class="center-align m-b-30">@lang('app.Add a new student')</h5>
                        <div class="input-field">
                            <select class="icons" name="student" required>
                                <option value="" disabled selected>@lang('app.Choose a new student')</option>
                                @foreach($students as $student)
                                    <option value="{{$student->id}}" data-icon="{{asset('/uploads/avatars/'.$student->avatar)}}">{{$student->getFullName()}}</option>
                                @endforeach
                            </select>
                            <label>@lang('app.All students')</label>
                        </div>
                        <button type="submit" class="indigo waves-effect waves-light btn right"><i class="material-icons right">add</i>@lang('app.New student')</button>
                        {!! Form::close() !!}
                    </div>
                </div>
                {{--Add new discipline--}}
                <div class="col s12 m6 l8">
                    <div class="card-panel hoverable">
                        {!! Form::open(['route' => ['team.discipline.store',$team->name], 'method' => 'POST']) !!}
                        <h5 class="center-align m-b-30">@lang('app.Add a new discipline')</h5>
                        <div class="input-field">
                            <select class="icons" name="teamTemplateDisciplines" required>
                                <option value="" disabled selected>@lang('app.Choose a new discipline')</option>
                                @foreach($teamTemplateDisciplines as $discipline)
                                    <option value="{{$discipline->id}}">{{$discipline->getTeacher->getFullName()}} - {{$discipline->getDiscipline->display_name}} {{$discipline->hours}} @lang('app.hours')</option>
                                @endforeach
                            </select>
                            <label>@lang('app.All disciplines')</label>
                        </div>
                        <button type="submit" class="indigo waves-effect waves-light btn right"><i class="material-icons right">add</i>@lang('app.New discipline')</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        @endif

        {{--Floating button--}}
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large red pulse">
                <i class="large material-icons">mode_edit</i>
            </a>
            <ul>
                @if($team->video_lessons)
                <li><a class="btn-floating green tooltipped" data-position="left" data-tooltip="@lang('app.Video Lessons')" href="{{url('/team/'.$team->name.'/video-lesson')}}"><i class="material-icons">ondemand_video</i></a></li>
                @endif
                @role('manager')
                <li><a class="btn-floating green tooltipped" data-position="left" data-tooltip="@lang('app.Common file')" href="{{url('/team/'.$team->name.'/common/file/create')}}"><i class="material-icons">attach_file</i></a></li>
                @endrole

                <li><a class="btn-floating green tooltipped" data-position="left" data-tooltip="@lang('app.Marks')" href="{{url('/team/'.$team->name.'/mark')}}"><i class="material-icons">bookmark_border</i></a></li>
                <li><a class="btn-floating green tooltipped" data-position="left" data-tooltip="@lang('app.Group Work')" href="{{url('/team/'.$team->name.'/group-work')}}"><i class="material-icons">group</i></a></li>
                <li><a class="btn-floating green tooltipped" data-position="left" data-tooltip="@lang('app.Activity')" href="{{url('/team/'.$team->name.'/activity')}}"><i class="material-icons">home</i></a></li>
                <li><a class="btn-floating green tooltipped" data-position="left" data-tooltip="@lang('app.Educational Materials')" href="{{url('/team/'.$team->name.'/material')}}"><i class="material-icons">import_contacts</i></a></li>
                <li><a class="btn-floating blue tooltipped" data-position="left" data-tooltip="@lang('app.Schedule')" href="{{url('/team/'.$team->name.'/schedule')}}"><i class="material-icons">access_time</i></a></li>
                <li><a class="btn-floating orange tooltipped" data-position="left" data-tooltip="@lang('app.Test')" href="{{url('/team/'.$team->name.'/pretest')}}"><i class="material-icons">border_color</i></a></li>
                @if(Auth::user()->hasRole(['administrator', 'top-manager', 'manager']))
                    <li><a class="btn-floating red tooltipped" data-position="left" data-tooltip="@lang('app.Settings')" href="{{url('/team/'.$team->name.'/setting')}}"><i class="material-icons">settings</i></a></li>
                @endif
            </ul>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        new Vue({
            el: '#team-dashboard',
            mounted(){
                console.log('Team dashboard mounted')
            },
            data: {
                video_lessons: {!! $team->video_lessons !!},
            },
            methods: {
                removeCommonFile(file){
                    axios.delete('/team/{!! $team->name !!}/common/file/' + file)
                        .then(res => {
                            location.reload();
                        })
                }
            }
        })
    </script>
@endsection