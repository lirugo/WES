@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('student') }}
@endsection
@section('content')
    <div class="row">
        @foreach($students as $student)
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title">{{$student->getShortName()}}</span>
                        <span class="card-title center-align"></span>
                        <p></p>
                        <div class="divider m-t-10 m-b-10"></div>
                        <blockquote class="m-b-0 m-t-5"><small>Email - {{$student->email}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>Phone - {{$student->getPhone()}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>Created at - {{$student->created_at->format('Y-m-d')}}</small></blockquote>
                    </div>
                    <div class="card-action right-align">
                        <a href="{{url('/student',$student->id)}}" class="indigo waves-effect waves-light btn-small right m-r-10">Open</a>
                    </div>
                </div>
            </div>
        @endforeach
        @if($students->all() == null)
            <div class="row">
                <div class="col s12">
                    <p>Sorry, but you do not have any free students...</p>
                </div>
            </div>
        @endif
    </div>
@endsection
