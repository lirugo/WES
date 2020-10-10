@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('changelog') }}
@endsection
@section('content')
    <div class="row">
        <div class="col s12 m8 offset-m2">
            @foreach($changelogs as $log)
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title">{{$log->title}}<span class="right"><small>{{\Carbon\Carbon::parse($log->created_at)->toDateString()}}</small></span></span>
                        <div class="divider m-b-10"></div>
                        <p>{!! $log->body !!}</p>

                        <div class="row">
                            <div class="col s6">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>Old</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (json_decode($log->old) as $key => $value)
                                        <tr>
                                            <td>{{$key}}</td>
                                            <td>{{$value}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col s6">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>Field</th>
                                        <th>New</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach (json_decode($log->new) as $key => $value)
                                        <tr>
                                            <td>{{$key}}</td>
                                            <td>{{$value}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="row">
                <div class="col s12">

                </div>
            </div>
        </div>
    </div>
    @role('administrator')
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large green tooltipped" href="{{url('/changelog/create')}}" data-position="left" data-tooltip="@lang('app.Add Log')">
            <i class="large material-icons">add</i>
        </a>
    </div>
    @endrole
@endsection