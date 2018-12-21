@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-group-work-show-sub-teams', $team, $discipline, $groupWork) }}
@endsection
@section('content')
    {{--Show type activity--}}
    <div id="sub-teams">
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
                        <button type="submit" class="waves-effect waves-light btn btn-small orange right">update</button>
                    @endif
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        {{--Create team--}}
        @role('teacher')
        <div class="row m-b-0">
            <div class="col s12">
                <div class="card-panel">
                    <div class="row m-b-0">
                        {{--Name--}}
                        <div class="input-field col s12 m8">
                            <input placeholder="Team Name" id="name" name="name" type="text" v-model="subteam.name" class="validate">
                        </div>
                        {{--Select members--}}
                        <div class="input-field col s12 m4">
                            <select v-model="newMember">
                                <option value="" disabled selected>Add members</option>
                                <option :value="member" v-for="member in members" :data-icon="'/uploads/avatars/'+member.avatar">@{{ member.name.second_name + ' ' + member.name.name }}</option>
                            </select>
                        </div>
                        {{--Show members--}}
                        <div class="chip m-l-10" v-for="(member, index) in subteam.members">
                            <img :src="'/uploads/avatars/' + member.avatar" alt="image">
                            @{{ member.name.second_name + ' ' + member.name.name }}
                            <i class="material-icons chip-icon" @click="excludeMember(index)">close</i>
                        </div>
                    </div>
                    {{--Create--}}
                    <a class="waves-effect waves-light btn btn-small right green" @click="createSubTeam"><i class="material-icons right">add</i>Create</a>
                </div>
            </div>
        </div>
        @endrole

        {{--Display teams--}}
        <div class="row m-b-0">
            <div class="col s12">
                <div class="card-panel" v-for="subteam in sortedSubTeams">
                    <div class="row m-b-0">
                        {{--Name--}}
                        <div class="input-field col s12">
                            <input placeholder="Team Name" id="name" name="name" type="text" :value="subteam.name" class="validate" disabled>
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
                            <a v-if="member.user.id == {{Auth::user()->id}}" :href="'/team/' + team.name + '/group-work/' + discipline.name + '/' + groupWork.id + '/' + subteam.id" class="waves-effect waves-light btn btn-small right indigo">Open</a>
                        </div>
                    @else
                        <a :href="'/team/' + team.name + '/group-work/' + discipline.name + '/' + groupWork.id + '/' + subteam.id" class="waves-effect waves-light btn btn-small right indigo">Open</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el:'#sub-teams',
            data: {
                team: {!! $team !!},
                discipline: {!! $discipline !!},
                groupWork: {!! $groupWork !!},
                newMember: null,
                members: {!! $team->getStudents() !!},
                subteam: {
                    name: null,
                    members: []
                },
                subteams: []
            },
            watch: {
                newMember(){
                    if(this.newMember)
                        this.subteam.members.push(this.newMember)
                    this.newMember = null
                }
            },
            computed: {
                sortedSubTeams() {
                    return this.subteams.sort((a, b) => -(a.id - b.id))
                }
            },
            created() {
                //Send post for create subteam
                axios.post('/team/{!! $team->name !!}/group-work/{!! $discipline->name !!}/{!! $groupWork->id !!}/getSubTeams')
                    .then(response => {
                        this.subteams = response.data
                    })
            },
            methods: {
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
