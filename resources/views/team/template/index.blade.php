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
                            <ul class="collection">
                            @foreach($template->disciplines as $discipline)
                                    <li class="collection-item avatar">
                                        <img src="{{asset('/uploads/avatars/'.$discipline->getTeacher->avatar)}}" alt="" class="circle m-t-10">
                                        <span class="title">{{$discipline->getDiscipline->display_name}}</span>
                                        <p>
                                            {{$discipline->getTeacher->getShortName()}}<br>
                                            @lang('app.Hours') - {{$discipline->hours}}
                                        </p>
                                    </li>
                            @endforeach
                            </ul>
                        </div>
                        <div class="row m-b-0">
                            @foreach($template->lessonsTime as $time)
                                <div class="input-field col s6 m3">
                                    <input type="text" value="{{\Carbon\Carbon::parse($time->start_time)->format('H:i')}} - {{\Carbon\Carbon::parse($time->end_time)->format('H:i')}}" disabled>
                                    <span class="helper-text" data-error="@lang('app.wrong')" data-success="@lang('app.All is OK')">@lang('app.Lesson') {{$time->position}}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-action right-align">
                        <a href="{{url('/team/template/'.$template->name.'/edit')}}" class="indigo waves-effect waves-light btn-small right m-r-10">@lang('app.Open')</a>
                    </div>
                </div>
            </div>
        @endforeach
        @if($templates->all() == null)
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
