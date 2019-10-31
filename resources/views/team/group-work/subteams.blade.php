@extends('layouts.app')
@section('breadcrumbs')
{{--    {{ Breadcrumbs::render('team-group-work-show-sub-teams', $team, $discipline, $groupWork) }}--}}
@endsection
@section('content')
    {{--Show type activity--}}
    <div id="sub-teams">
        <v-app class="grey lighten-3">
            <v-container fluid ma-0 pa-0>
            {{--GroupWorks--}}
            <div class="row m-b-0">
                <div class="col s12">
                    <div class="card-panel">
                        <div class="row m-b-0">
                            <span class="card-title">{{$groupWork->name}}</span>
                            <p>{{$groupWork->description}}</p>
                            <div class="row m-b-0">
                                @foreach($groupWork->files as $file)
                                    <form action="{{url('/team/group-work/getFile/'.$file->file)}}" method="POST">
                                        @csrf
                                        <button class="btn btn-small waves-effect waves-light indigo m-l-10" type="submit">
                                            {{$file->name}}
                                            <i class="material-icons right">file_download</i>
                                        </button>
                                    </form>
                                @endforeach
                            </div>
                            {!! Form::open(['url' => '/team/'.$team->name.'/group-work/'.$discipline->name.'/'.$groupWork->id.'/updateGroupWork']) !!}
                            <div class="input-field col s12 m6">
                                <input name="start_date" type="text" value="{{ \Carbon\Carbon::parse($groupWork->start_date)->format('Y-m-d') }}" class="datepickerDefault">
                            </div>
                            <div class="input-field col s12 m6">
                                <input name="end_date" type="text" value="{{ \Carbon\Carbon::parse($groupWork->end_date)->format('Y-m-d') }}" class="datepickerDefault">
                            </div>
                            @if(Auth::user()->hasRole(['teacher', 'manager']))
                                @if(!$groupWork->isFinished())
                                    <button type="submit" class="waves-effect waves-light btn btn-small orange right">@lang('app.update')</button>
                                @endif
                            @endif
                            {!! Form::close() !!}

                            @role('teacher')
                            @if(!$groupWork->isFinished())
                                {!! Form::open(['route' => ['team.group-work.finish', $team->name, $discipline->name, $groupWork->id]]) !!}
                                <button type="submit" class="waves-effect waves-light btn btn-small red left tooltipped" data-position="bottom" data-tooltip="@lang('app.Press for closing group work')">@lang('app.Finish')</button>
                                {!! Form::close() !!}
                            @endif
                            @endrole

                            @if($groupWork->isFinished())
                                <a href="#" class="waves-effect waves-light btn btn-small red left tooltipped" data-position="bottom" data-tooltip="@lang('app.That group work was be closed')"><i class="material-icons">lock</i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{--Create team--}}
            @role('teacher')
            @if(!$groupWork->isFinished())
                <div class="row m-b-0">
                    <div class="col s12">
                        <div class="card-panel">
                            <div class="row m-b-0">
                                {{--Name--}}
                                <div class="input-field col s12 m6">
                                    <input placeholder="@lang('app.Team Name')" id="name" name="name" type="text" v-model="subteam.name" class="validate">
                                </div>
                                {{--Select members--}}
                                <div class="input-field col s12 m6">
                                    <v-select
                                            v-model="newMember"
                                            :items="members"
                                            item-text="getName"
                                            return-object
                                            label="Students"
                                    >
                                    </v-select>
                                    {{--                            <select v-model="newMember" id="mySelect">--}}
                                    {{--                                <option value="" disabled selected>Add members</option>--}}
                                    {{--                                <option :value="member" v-for="(member, index) in members" id="option-11" :data-icon="'/uploads/avatars/'+member.avatar">@{{ member.name.second_name + ' ' + member.name.name }}</option>--}}
                                    {{--                            </select>--}}
                                </div>
                                {{--                        Show members--}}
                                <div class="chip m-l-10" v-for="(member, index) in subteam.members">
                                    <img :src="'/uploads/avatars/' + member.avatar" alt="image">
                                    @{{ member.name.second_name ? member.name.second_name : '' + ' ' + member.name.name }}
{{--                                    <i class="material-icons chip-icon" @click="excludeMember(index)">close</i>--}}
                                </div>
                            </div>
                            {{--Create--}}
                            <a class="waves-effect waves-light btn btn-small right green" @click="createSubTeam"><i class="material-icons right">add</i>@lang('app.Create')</a>
                        </div>
                    </div>
                </div>
            @endif
            @endrole
            {{--Display teams--}}
            <div class="row m-b-0">
                <div class="col s12">
                    <div class="card-panel" v-for="subteam in sortedSubTeams">
                        <div class="row m-b-0">
                            {{--Name--}}
                            <div class="input-field col s12">
                                <input placeholder="@lang('app.Team Name')" id="name" name="name" type="text" :value="subteam.name" class="validate" disabled>
                            </div>
                            {{--Show members--}}
                            <div class="chip m-l-10" v-for="(member, index) in subteam.members">
                                <img :src="'/uploads/avatars/' + member.user.avatar" alt="image">
                                @{{ member.user.name.second_name + ' ' + member.user.name.name }}
                            </div>
                        </div>
                        {{--Open--}}
                        @if(Auth::user()->hasRole('student'))
                            <div v-for="member in subteam.members">
                                <a v-if="member.user.id == {{Auth::user()->id}}" :href="'/team/' + team.name + '/group-work/' + discipline.name + '/' + groupWork.id + '/' + subteam.id" class="waves-effect waves-light btn btn-small right indigo">@lang('app.Open')</a>
                            </div>
                        @else
                            <a :href="'/team/' + team.name + '/group-work/' + discipline.name + '/' + groupWork.id + '/' + subteam.id" class="waves-effect waves-light btn btn-small right indigo">@lang('app.Open')</a>
                        @endif
                    </div>
                </div>
            </div>
            </v-container>
        </v-app>
    </div>
@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/vuetify@1.x/dist/vuetify.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vuetify@1.x/dist/vuetify.js"></script>
    <script>
        new Vue({
            el:'#sub-teams',
            data: {
                items: ['Foo', 'Bar', 'Fizz', 'Buzz'],
                team: {!! $team !!},
                discipline: {!! $discipline !!},
                groupWork: {!! $groupWork !!},
                newMember: null,
                members: {!! json_encode($students) !!},
                subteam: {
                    name: null,
                    members: []
                },
                subteams: []
            },
            watch: {
                newMember(){
                    if(this.newMember) {
                        this.members = this.members.filter(member => {
                            return member.id != this.newMember.id;
                        })
                        this.subteam.members.push(this.newMember)
                    }
                    this.newMember = null
                }
            },
            computed: {
                sortedSubTeams() {
                    return this.subteams.sort((a, b) => -(a.id - b.id))
                }
            },
            created() {
                axios.post('/team/{!! $team->name !!}/group-work/{!! $discipline->name !!}/{!! $groupWork->id !!}/getSubTeams')
                    .then(response => {
                        this.subteams = response.data
                    })
            },
            methods: {
                excludeStudent(){
                    document.getElementsByClassName("option-1")[0].style.display =  "none";
                },
                excludeMember(index){
                    this.subteam.members.splice(index, 1)
                },
                createSubTeam(){
                    if(this.subteam.name){
                        //Send post for create subteam
                        axios.post('/team/{!! $team->name !!}/group-work/{!! $discipline->name !!}/{!! $groupWork->id !!}/storeSubTeam', this.subteam)
                            .then(response => {
                                this.subteams.push(response.data)
                            })
                            .finally(() => {
                                M.toast({html: 'Sub Team was successfully created', classes: 'green'})
                            })
                        //Clear data
                        this.subteam = {
                            name: null,
                            members: []
                        }
                    }
                    else  M.toast({html: 'Oh snap - Check data', classes: 'red'})

                }
            }
        })
    </script>
@endsection
