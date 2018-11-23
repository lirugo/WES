@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest', $team) }}
@endsection
@section('content')
    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <span>Subject with Pretest</span>
            </div>
        </div>
    </div>
    @role('teacher')
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <a href="{{url('/team/'.$team->name.'/pretest/create')}}" class="btn-floating btn-large green tooltipped" data-position="left"
                data-tooltip="Create Pretest">
            <i class="large material-icons">add</i>
        </a>
    </div>
    @endrole
@endsection
