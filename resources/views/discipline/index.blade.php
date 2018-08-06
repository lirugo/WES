@extends('layouts.app')

@section('content')
    <div class="row">
        @foreach($disciplines as $discipline)
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">{{$discipline->display_name}}</span>
                        <p>{{$discipline->description}}</p>
                    </div>
                    <div class="card-action right-align">
                        <a href="{{url('/discipline/'.$discipline->name.'/edit')}}" class="indigo waves-effect waves-light btn-small right">Edit</a>
                    </div>
                </div>
            </div>
        @endforeach
        @if($disciplines->all() == null)
            <div class="row">
                <div class="col s12">
                    <div class="card-panel orange white-text">
                        <h5 class="center-align m-t-0 m-b-0-">Sorry, but you do not have any discipline...</h5>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
