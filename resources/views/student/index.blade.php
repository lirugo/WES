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
                        <span class="card-title">{{$student->getFullName()}}</span>
                        <span class="card-title center-align"></span>
                        <p></p>
                        <div class="divider m-t-10 m-b-10"></div>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Email') - {{$student->email}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Phone') - {{$student->getPhone()}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Created at') - {{$student->created_at->format('Y-m-d')}}</small></blockquote>
                    </div>
                    <div class="card-action right-align">
                        <a href="{{url('/student',$student->id)}}" class="indigo waves-effect waves-light btn-small right m-r-10">@lang('app.Open')</a>
                    </div>
                </div>
            </div>
        @endforeach
        @if($students->all() == null)
            <div class="row">
                <div class="col s12">
                    <p>@lang('app.Sorry, but you do not have any free students...')</p>
                </div>
            </div>
        @endif
    </div>
@endsection
