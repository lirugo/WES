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
                    <span class="card-title">{{$groupWork->name}}</span>
                    <p>{{$groupWork->description}}</p>
                    @foreach($groupWork->files as $file)
                        <form action="{{url('/team/group-work/getFile/'.$file->file)}}" method="POST">
                            @csrf
                            <button class="btn btn-small waves-effect waves-light indigo m-b-5" type="submit">
                                {{$file->name}}
                                <i class="material-icons right">file_download</i>
                            </button>
                        </form>
                    @endforeach
                    <small><blockquote class="m-b-0 m-t-15">Start date - {{$groupWork->start_date}}</blockquote></small>
                    <small><blockquote class="m-b-0 m-t-5">End date - {{$groupWork->end_date}}</blockquote></small>
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
    </div>
@endsection

@section('scripts')
    <script>
        function removeMember(members, member) {
            for (let i = 0; i < members.length; i++) {
                let obj = members[i];
                if (obj.id == member.id) {
                    members.splice(i, 1);
                    i--;
                }
            }
            return members
        }

        new Vue({
            el:'#sub-teams',
            data: {
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
            methods: {
                excludeMember(index){
                    this.subteam.members.splice(index, 1)
                },
                createSubTeam(){
                    if(this.subteam.name){
                        //Send post for create subteam
                        axios.post('/team/{!! $team->name !!}/group-work/{!! $discipline->name !!}/{!! $groupWork->id !!}/storeSubTeam', this.subteam)
                            .then(response => {
                                console.log(response.data)
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
