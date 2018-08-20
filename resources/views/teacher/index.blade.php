@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('teacher') }}
@endsection

@section('content')
    <div class="row">
        @foreach($teachers as $teacher)
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-image">
                        <img src="{{asset('/uploads/avatars/'.$teacher->avatar)}}">
                        <span class="card-title">{{$teacher->getShortName()}}</span>
                    </div>
                    <div class="card-content">
                        <span class="card-title center-align"></span>
                        <p></p>
                        <div class="divider m-t-10 m-b-10"></div>
                        <blockquote class="m-b-0 m-t-5"><small>Email - {{$teacher->email}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>Phone - {{$teacher->getPhone()}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>Created at - {{$teacher->created_at->format('Y-m-d')}}</small></blockquote>
                    </div>
                    <div class="card-action right-align">
                        <a href="{{url('/teacher/'.$teacher->id.'/edit')}}" class="indigo waves-effect waves-light btn-small right">Edit</a>
                    </div>
                </div>
            </div>
        @endforeach
        @if($teachers->all() == null)
            <div class="row">
                <div class="col s12">
                    <div class="card-panel orange white-text">
                        <h5 class="center-align m-t-0 m-b-0-">Sorry, but you do not have any groups...</h5>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
