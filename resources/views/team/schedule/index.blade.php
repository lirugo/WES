@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-show-schedule', $team) }}
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
@endsection
@section('content')
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card hoverable">
                <div class="card-content">
                    {!! $calendar->calendar() !!}
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->hasRole(['administrator', 'top-manager', 'manager', 'teacher']))
        <div class="row">
            <div class="col s12">
                <div class="card hoverable">
                    <div class="card-content">
                        <table class="striped">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(Auth::user()->hasRole('teacher'))
                                @foreach($team->getTeacherSchedules() as $schedule)
                                    <tr>
                                        <td>{{$schedule->title}}</td>
                                        <td>{{$schedule->start_date}}</td>
                                        <td>{{$schedule->end_date}}</td>
                                        <td>
                                            {{--If start date - date now more than 14 day teacher can delete lecture--}}
                                            @if(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($schedule->start_date), false) > 14)
                                                {!! Form::open(['route' => ['team.schedule.delete', $team->name, $schedule->id]]) !!}
                                                <button type="submit" class="waves-effect waves-light btn red"><i class="material-icons">delete</i></button>
                                                {!! Form::close() !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach($team->schedules as $schedule)
                                    <tr>
                                        <td style="max-width: 500px;">{{$schedule->title}}</td>
                                        <td>{{$schedule->start_date}}</td>
                                        <td>{{$schedule->end_date}}</td>
                                        <td>
                                            {!! Form::open(['route' => ['team.schedule.delete', $team->name, $schedule->id]]) !!}
                                            <button type="submit" class="waves-effect waves-light btn red"><i class="material-icons">delete</i></button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{--Floating button--}}
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large red" href="{{url('/team/'.$team->name.'/schedule/create')}}">
                <i class="large material-icons">add</i>
            </a>
        </div>
    @endif

@endsection

@section('scripts')
    <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    {!! $calendar->script() !!}
@endsection