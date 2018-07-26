@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col s8">
            <div class="card white">
                <div class="card-content">
                    <span class="card-title">News</span>
                    <p>
                        Welcome ur login in, as {{Auth::user()->roles()->first()->name}}
                    </p>
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="card white">
                <div class="card-content">
                    <span class="card-title">Events</span>
                    <p>I am a very simple card. I am good at containing small bits of information.
                        I am convenient because I require little markup to use effectively.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s8">
            <div class="card white">
                <div class="card-content">
                    <span class="card-title">Shedule</span>
                    <p>
                        Welcome ur login in, as {{Auth::user()->roles()->first()->name}}
                    </p>
                </div>
            </div>
        </div>
        <div class="col s4">
            <div class="card white">
                <div class="card-content">
                    <span class="card-title">Groups</span>
                    <p>I am a very simple card. I am good at containing small bits of information.
                        I am convenient because I require little markup to use effectively.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
