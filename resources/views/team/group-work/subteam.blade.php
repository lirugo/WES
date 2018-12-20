@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-group-work-show-sub-teams-sub-team', $team, $discipline, $groupWork, $subTeam) }}
@endsection
@section('content')
    <div>
        {{--Display team--}}
        <div class="row m-b-0">
            <div class="col s12">
                <div class="card-panel hoverable">
                    <div class="row m-b-0">
                        {{--Name--}}
                        <div class="input-field col s12">
                            <input placeholder="Team Name" id="name" name="name" type="text" value="{{$subTeam->name}}" class="validate" disabled>
                        </div>
                        {{--Show members--}}
                        @foreach($subTeam->members as $member)
                            <div class="chip m-l-10">
                                <img src="/uploads/avatars/{{$member->user->avatar}}" alt="image">
                                {{$member->user->name->second_name.' '.$member->user->name->name}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
