@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('changelog') }}
@endsection
@section('content')
    <div class="row">
        <div class="col s12 m8 offset-m2">
            @foreach($changelogs as $log)
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title">{{$log->title}}<span class="right"><small>{{\Carbon\Carbon::parse($log->created_at)->toDateString()}}</small></span></span>
                        <div class="divider m-b-10"></div>
                        <p>{!! $log->body !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @role('administrator')
        {{--Floating button--}}
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large green tooltipped" href="{{url('/changelog/create')}}" data-position="left" data-tooltip="@lang('app.Add Log')">
                <i class="large material-icons">add</i>
            </a>
        </div>
    @endrole
@endsection