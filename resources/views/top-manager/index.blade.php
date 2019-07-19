@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('top-manager') }}
@endsection
@section('content')
    <div class="row">
        @foreach($topManagers as $manager)
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-image">
                        <img src="{{asset('/uploads/avatars/'.$manager->avatar)}}">
                        <span class="card-title">{{$manager->getShortName()}}</span>
                    </div>
                    <div class="card-content">
                        <span class="card-title center-align"></span>
                        <p></p>
                        <div class="divider m-t-10 m-b-10"></div>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Email') - {{$manager->email}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Phone') - {{$manager->getPhone()}}</small></blockquote>
                        <blockquote class="m-b-0 m-t-5"><small>@lang('app.Created at') - {{$manager->created_at->format('Y-m-d')}}</small></blockquote>
                    </div>
                    {{--<div class="card-action right-align">--}}
                        {{--<a href="" class="indigo waves-effect waves-light btn-small right">Edit</a>--}}
                        {{--<a href="{{url('/student',$manager->id)}}" class="indigo waves-effect waves-light btn-small right m-r-10">Open</a>--}}
                    {{--</div>--}}
                </div>
            </div>
        @endforeach
        @if($topManagers->all() == null)
            <div class="row">
                <div class="col s12">
                    <div class="card-panel orange white-text">
                        <h5 class="center-align m-t-0 m-b-0-">@lang('app.Sorry, but you do not have any groups...')</h5>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
