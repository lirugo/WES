@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('student-team-schedule', $team) }}
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
@endsection

@section('content')
    <div class="row">
        <div class="col s12 m12 l12 m-t-20">
            <div class="card">
                <div class="card-content">
                    {!! $calendar->calendar() !!}
                </div>
            </div>
        </div>
    </div>
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