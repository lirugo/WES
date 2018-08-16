@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('student') }}
@endsection
@section('content')
    {{--Header--}}
    <div class="row">
        <div class="col s12">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title center-align">All students</span>
                    <a href="{{url('/manage')}}" class="indigo waves-effect waves-light btn left m-r-10"><i class="material-icons left">apps</i>Back to manage</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($students as $student)
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-image">
                        <img src="{{asset('/uploads/avatars/'.$student->avatar)}}">
                        <span class="card-title">{{$student->getShortName()}}</span>
                    </div>
                    <div class="card-content">
                        <span class="card-title center-align"></span>
                        <p></p>
                        <div class="divider m-t-10 m-b-10"></div>
                        <blockquote class="m-b-0 m-t-5"><small>Email - {{$student->email}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>Phone - {{$student->getPhone()}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>Created at - {{$student->created_at->format('Y-m-d')}}</small></blockquote>
                    </div>
                    <div class="card-action right-align">
                        <a href="" class="indigo waves-effect waves-light btn-small right">Edit</a>
                        <a href="{{url('/student',$student->id)}}" class="indigo waves-effect waves-light btn-small right m-r-10">Open</a>
                    </div>
                </div>
            </div>
        @endforeach
        @if($students->all() == null)
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
