@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('manage') }}
@endsection

@section('content')
    <div class="row">
        <div class="col s12 m8 l8">
            <div class="card white">
                <div class="card-content">
                    <span class="card-title">News</span>
                    <p>
                         {{Auth::user()->roles()->first()->name}}
                    </p>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4">
            <div class="card white">
                <div class="card-content">
                    <span class="card-title">@lang('app.Events')</span>
                    <p>@lang('app.I am a very simple card. I am good at containing small bits of information.
                        I am convenient because I require little markup to use effectively.')</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m8 l8">
            <div class="card white">
                <div class="card-content">
                    <span class="card-title">@lang('app.Schedules')</span>
                    <p>
                        @lang('app.Welcome ur login in, as') {{Auth::user()->roles()->first()->name}}
                    </p>
                </div>
            </div>
        </div>
        <div class="col s12 m4 l4">
            <div class="card white">
                <div class="card-content">
                    <span class="card-title">@lang('app.Groups')</span>
                    <p>@lang('app.I am a very simple card. I am good at containing small bits of information.
                        I am convenient because I require little markup to use effectively.')</p>
                </div>
            </div>
        </div>
    </div>
@endsection
