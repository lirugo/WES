@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-material-show', $team) }}
@endsection
@section('content')
    <div class="row">
        <div class="col s12 m6">
            @foreach($materials as $material)
                <div class="card-panel">
                    {!! Form::open(['url' => '/team/material/getFile/'.$material->file, 'method' => 'POST']) !!}
                    <button type="submit" class="btn btn-small indigo waves-effect">
                        <i class="material-icons left">cloud_download</i>
                        <span class="m-l-5">{{$material->name}}</span>
                    </button>
                    {!! Form::close() !!}
                    <p><blockquote>Uploaded - {{$material->created_at->diffForHumans()}}</blockquote></p>
                    @if(Auth::user()->hasRole('teacher'))
                        {!! Form::open(['route' => ['team.material.delete', $material->id]]) !!}
                            <button type="submit" class="waves-effect waves-light btn btn-small red right"><i class="material-icons">delete</i></button>
                        {!! Form::close() !!}
                    @endif
                </div>
            @endforeach
        </div>
        @if(Auth::user()->hasRole(['manager', 'teacher']))
        {{--Floating button--}}
        <div class="fixed-action-btn">
            <a href="{{url('/team/'.$team->name.'/material/create')}}" class="btn-floating btn-large green tooltipped" data-position="left"
               data-tooltip="Upload Material">
                <i class="large material-icons">add</i>
            </a>
        </div>
        @endif
    </div>
@endsection
