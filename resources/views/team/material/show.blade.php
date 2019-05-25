@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-material-discipline', $team, $discipline) }}
@endsection

@section('content')
    {{--    OLD EDUCATION MATERIALS--}}
    <div class="row m-b-0 m-t-0">
        <div class="col s12">
            <div class="card-panel">
                <div class="row m-b-0 m-t-0">
                    @foreach($materials as $material)
                        <div class="col s12 m6 m-b-5 m-t-5">
                            {{--                            @if(Auth::user()->hasRole('teacher') || Auth::user()->hasRole('manager'))--}}
                            {{--                                {!! Form::open(['route' => ['team.material.delete', $material->id]]) !!}--}}
                            {{--                                <button type="submit" class="waves-effect waves-light btn btn-small red left m-r-5"><i class="material-icons">delete</i></button>--}}
                            {{--                                {!! Form::close() !!}--}}
                            {{--                            @endif--}}
                            {!! Form::open(['url' => '/team/material/getFile/'.$material->file, 'method' => 'POST']) !!}
                            <button type="submit" class="btn btn-small indigo waves-effect p-b-5">
                                <i class="material-icons left">cloud_download</i>
                                <span class="m-l-5">{{$material->name}}</span>
                            </button>
                            {{--                            <small>{{$material->created_at->diffForHumans()}}</small>--}}
                            {!! Form::close() !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{--    Show categories--}}
    <div class="row">
        <div class="col s12 m8">
            @foreach($categories as $category)
                <div class="card-panel p-t-10">
                    @role(['teacher', 'manager'])
                    {!! Form::open(['route' => ['team.category.delete', $category->id]]) !!}
                    <button type="submit" class="waves-effect waves-light btn btn-small red right m-t-5" style=""><i class="material-icons">delete</i></button>
                    {!! Form::close() !!}
                    @endrole
                    <h6 class="center">{{$category->name}}</h6>
                    <hr>
                    <div class="row m-b-0 m-t-0">
                        {{--                        ONLY PUBLIC FOR STUDENTS--}}
                        @if(Auth()->user()->hasRole('student'))
                            @foreach($category->getMaterials() as $material)
                                <div class="col s12 m-b-5 m-t-5">
                                    {!! Form::open(['url' => '/team/material/getMaterialFile/'.$material->file_name, 'method' => 'POST']) !!}
                                    {{$material->name}}
                                    <button type="submit" class="btn btn-small green waves-effect p-b-5 right">
                                        <i class="material-icons">file_download</i>
                                    </button>
                                    {!! Form::close() !!}
                                </div>
                            @endforeach
                        @else
                            @foreach($category->getAllMaterials() as $material)
                                <div class="col s12 m-b-5 m-t-5">
                                    @role('teacher')
                                    <a href="{{url('/team/'.$team->name.'/material/'.$discipline->name.'/'.$material->id.'/edit')}}" class="btn btn-small orange right m-l-5">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    @endrole
                                    @if(Auth::user()->hasRole('teacher') || Auth::user()->hasRole('manager'))
                                        {!! Form::open(['route' => ['team.material.delete', $material->id]]) !!}
                                        <button type="submit" class="waves-effect waves-light btn btn-small red right m-l-5"><i class="material-icons">delete</i></button>
                                        {!! Form::close() !!}
                                    @endif
                                    {!! Form::open(['url' => '/team/material/getMaterialFile/'.$material->file_name, 'method' => 'POST']) !!}
                                    {{$material->name}}
                                    <button type="submit" class="btn btn-small green waves-effect p-b-5 right">
                                        <i class="material-icons">file_download</i>
                                    </button>
                                    <span data-badge-caption="" class="new badge grey left m-l-5">{{$material->public_date}}</span>
                                    @if($material->type == 'staff')
                                        <span data-badge-caption="" class="new badge orange darken-3 left m-l-5">Staff</span>
                                    @else
                                        <span data-badge-caption="" class="new badge orange left m-l-5">Public</span>
                                    @endif
                                    @if($material->public_date < \Carbon\Carbon::now())
                                        <span data-badge-caption="" class="new badge green left m-l-5 m-r-10">Published</span>
                                    @else
                                        <span data-badge-caption="" class="new badge red left m-l-5 m-r-10">Not published</span>
                                    @endif
                                    {!! Form::close() !!}
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col s12 m4">
        {{--    Show links--}}
            <ul class="collection with-header">
                <li class="collection-header"><h6 class="center">Links</h6></li>
                @foreach($links as $link)
                    <div class="collection m-t-0 m-b-0 p-l-0 p-r-0">
                        @if(Auth::user()->hasRole('teacher') || Auth::user()->hasRole('manager'))
                            {!! Form::open(['route' => ['team.link.delete', $link->id]]) !!}
                            <button type="submit" class="waves-effect waves-light btn btn-small red right m-r-10 m-t-5" style=""><i class="material-icons">delete</i></button>
                            {!! Form::close() !!}
                        @endif
                        <a href="{{$link->link}}" class="collection-item p-l-0 p-r-0" target="_blank">{{$link->name}}
                            <span data-badge-caption="" class="new badge grey left m-r-10">{{$link->public_date}}</span>
                        </a>
                    </div>

                @endforeach
            </ul>

            {{-- Show Video--}}
            <div class="card-panel p-t-10">
                <h6 class="center">Video</h6>
                <hr>
                @foreach($videos as $video)
                    @role(['teacher', 'manager'])
                    {!! Form::open(['route' => ['team.video.delete', $video->id]]) !!}
                    <button type="submit" class="waves-effect waves-light btn red m-t-5" style="width: 100%;"><i class="material-icons">delete</i></button>
                    {!! Form::close() !!}
                    @endrole
                    <div class="resp-container m-b-10">
                        {!! $video->getVideoHtmlAttribute() !!}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if(Auth::user()->hasRole(['manager', 'teacher']))
        {{--Floating button--}}
        <div class="fixed-action-btn">
            <a href="{{url('/team/'.$team->name.'/material/'.$discipline->name.'/create')}}" class="btn-floating btn-large green tooltipped" data-position="left"
               data-tooltip="Add New Material">
                <i class="large material-icons">add</i>
            </a>
            <ul>
                <li><a class="btn-floating green tooltipped" data-position="left"
                       data-tooltip="Add New Category"
                       href="{{url('/team/'.$team->name.'/material/'.$discipline->name.'/category/create')}}"><i class="material-icons">merge_type</i></a></li>
                <li><a class="btn-floating green tooltipped" data-position="left"
                       data-tooltip="Add New Link"
                       href="{{url('/team/'.$team->name.'/material/'.$discipline->name.'/link/create')}}"><i class="material-icons">insert_link</i></a></li>
                <li><a class="btn-floating green tooltipped" data-position="left"
                       data-tooltip="Add New Video"
                       href="{{url('/team/'.$team->name.'/material/'.$discipline->name.'/video/create')}}"><i class="material-icons">ondemand_video</i></a></li>
            </ul>
        </div>
    @endif
@endsection
