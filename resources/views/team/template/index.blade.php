@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-template') }}
@endsection
@section('content')
    <div class="row">
        @foreach($templates as $template)
            <div class="col s12">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">{{$template->display_name}}</span>
                        <div class="row m-b-0">
                            @foreach($template->disciplines as $discipline)
                                <div class="col s12 l6 m-b-20 card card-content hoverable height-200px">
                                    <a href="#user"><img class="circle left m-r-10" width="100px" src="{{asset('/uploads/avatars/'.$discipline->getTeacher->avatar)}}"></a>
                                    <p class="m-t-10">{{$discipline->getDiscipline->display_name}}</p>
                                    <p>{{$discipline->getTeacher->getShortName()}}</p>
                                    <p>Hours - {{$discipline->hours}}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-action right-align">
                        <a href="{{url('/team/template/'.$template->name.'/edit')}}" class="indigo waves-effect waves-light btn-small right m-r-10">Open</a>
                    </div>
                </div>
            </div>
        @endforeach
        @if($templates->all() == null)
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
