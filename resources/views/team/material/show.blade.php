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
                            @if(Auth::user()->hasRole('teacher') || Auth::user()->hasRole('manager'))
                                {!! Form::open(['route' => ['team.material.delete', $material->id]]) !!}
                                <button type="submit" class="waves-effect waves-light btn btn-small red left m-r-5"><i class="material-icons">delete</i></button>
                                {!! Form::close() !!}
                            @endif
                            {!! Form::open(['url' => '/team/material/getFile/'.$material->file, 'method' => 'POST']) !!}
                            <button type="submit" class="btn btn-small indigo waves-effect p-b-5">
                                <i class="material-icons left">cloud_download</i>
                                <span class="m-l-5">{{$material->name}}</span>
                            </button>
                            <small>{{$material->created_at->diffForHumans()}}</small>
                            {!! Form::close() !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

{{--    Show categories--}}
    <div class="row">
    @foreach($categories as $category)
            <div class="col s12">
                <div class="card-panel">
                    <h6 class="center">{{$category->name}}</h6>
                </div>
            </div>
    @endforeach
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
                       href="#"><i class="material-icons">insert_link</i></a></li>
                <li><a class="btn-floating green tooltipped" data-position="left"
                       data-tooltip="Add New Video"
                       href="#"><i class="material-icons">ondemand_video</i></a></li>
            </ul>
        </div>
    @endif
@endsection
