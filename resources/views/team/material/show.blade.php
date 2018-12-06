@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-material-show', $team) }}
@endsection
@section('content')
    <div class="row">
        <div class="col s12 m6">
            @foreach($materials as $material)
                <div class="card-panel">
                    {!! Form::open(['route' => ['team.material.getFile', $material->name]]) !!}
                    <button type="submit" class="btn btn-small indigo waves-effect">
                        <i class="material-icons left">cloud_download</i>
                        <span class="m-l-5">{{$material->name}}</span>
                    </button>
                    {!! Form::close() !!}
                    <p><blockquote>Uploaded - {{$material->created_at->diffForHumans()}}</blockquote></p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
