@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-group-work-show', $team, $discipline) }}
@endsection
@section('content')
    {{--Show type activity--}}
    <div id="group-work">
        {{--Create--}}
        <group-work-create
            :team_name="{{ json_encode($team->name) }}"
            :discipline_name="{{ json_encode($discipline->name) }}"
            :teacher_id="{{ json_encode(Auth::user()->id) }}"></group-work-create>
        {{--Display--}}
        show page
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el:'#group-work',
            data: {

            },
            methods:{

            }
        })
    </script>
@endsection
