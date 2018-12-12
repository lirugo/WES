@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-activity', $team) }}
@endsection
@section('content')
    {{--Show type activity--}}
    <div class="row">
        @foreach($disciplines as $discipline)
            <div class="col s12 m4">
                <div class="card hoverable">
                    <div class="card-content">
                        <span class="card-title center-align">{{$discipline->getDiscipline->display_name}}</span>
                    </div>
                    <div class="card-action">
                        <a href="{{url('team/'.$team->name.'/activity/'.$discipline->getDiscipline->name)}}" class=" waves-effect waves-light btn-small right indigo">Open</a>
                    </div>
                </div>
            </div>
        @endforeach

        {{--Link create page--}}
        <div class="fixed-action-btn">
            <a class="btn-floating btn-large waves-effect waves-light green" href="{{url('team/'.$team->name.'/activity/create')}}"><i class="material-icons">add</i></a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

    </script>
@endsection
