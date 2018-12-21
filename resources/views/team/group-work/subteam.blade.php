@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-group-work-show-sub-teams-sub-team', $team, $discipline, $groupWork, $subTeam) }}
@endsection
@section('content')
    <div id="sub-team-chat">
        {{--Display team--}}
        <div class="row m-b-0">
            <div class="col s12">
                <div class="card-panel hoverable">
                    {!! Form::open(['url' => '/team/'.$team->name.'/group-work/'.$discipline->name.'/'.$groupWork->id.'/'.$subTeam->id.'/updateSubTeam']) !!}
                    <div class="row m-b-0">
                        {{--Name--}}
                        <div class="input-field col s12 m-b-0">
                            <input placeholder="Team Name" id="name" name="name" type="text" value="{{$subTeam->name}}" class="validate" disabled>
                        </div>
                        <div class="input-field col s12 m4">
                            <input name="start_date" type="text" value="{{ json_decode($subTeam->getDeadline())->startDate }}" class="datepickerDefault" {{Auth::user()->hasRole(['teacher', 'manager']) ? '' : 'disabled'}}>
                            <span class="helper-text" data-error="wrong" data-success="right">Start Date</span>
                        </div>
                        <div class="input-field col s12 m4">
                            <input name="end_date" type="text" value="{{ json_decode($subTeam->getDeadline())->endDate }}" class="datepickerDefault" {{Auth::user()->hasRole(['teacher', 'manager']) ? '' : 'disabled'}}>
                            <span class="helper-text" data-error="wrong" data-success="right">End Date</span>
                        </div>
                        {{--Add new member--}}
                        @role('teacher')
                        <div class="input-field col s12 m4">
                            <select v-model="newMember">
                                <option value="" disabled selected>Add members</option>
                                <option :value="student" v-for="student in students" :data-icon="'/uploads/avatars/'+student.avatar">@{{ student.name.second_name + ' ' + student.name.name }}</option>
                            </select>
                            <span class="helper-text" data-error="wrong" data-success="right"></span>
                        </div>
                        @endrole
                    </div>
                    <div class="row m-b-0">
                        {{--Show members--}}
                        @if(Auth::user()->hasRole('teacher'))
                            <div class="chip m-l-10" v-for="member in members">
                                <img :src="'/uploads/avatars/' + member.user.avatar" alt="image">
                                @{{member.user.name.second_name + ' ' + member.user.name.name}}
                                <i class="chip-icon material-icons" @click="removeMember(member.user.id)">close</i>
                            </div>
                        @else
                            <div class="chip m-l-10" v-for="member in members">
                                <img :src="'/uploads/avatars/' + member.user.avatar" alt="image">
                                @{{member.user.name.second_name + ' ' + member.user.name.name}}
                            </div>
                        @endif
                    </div>
                    @if(Auth::user()->hasRole(['teacher', 'manager']))
                        <button type="submit" class="waves-effect waves-light btn btn-small orange right">update</button>
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        {{--Chat--}}
        <div class="row">
            <div class="col s12">
                {{--Create message--}}
                <div class="card-panel">
                    <div class="input-field">
                        <input id="text" name="text" placeholder="Write your message" type="text" v-model="message.text" class="validate">
                    </div>
                    <a class="waves-effect waves-light btn btn-small indigo right" @click="sendMessage">send</a>
                </div>
                {{--Show Chat--}}
                <div class="card-panel" v-for="message in sortedMessages">
                    <div class="chip">
                        <img :src="'/uploads/avatars/' + message.author.avatar" alt="image">
                        @{{ message.author.name.second_name + ' ' + message.author.name.name }}
                    </div>
                    <p class="card-text">@{{ message.text }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el:'#sub-team-chat',
            data: {
                message: {
                    text: null
                },
                messages: [],
                newMember: null,
                students: {!! $team->getStudents() !!},
                members: {!! $subTeam->members !!},
            },
            created(){
                axios.post('/team/{!! $team->name !!}/group-work/{!! $discipline->name !!}/{!! $groupWork->id !!}/{!! $subTeam->id !!}/getMessages')
                    .then(response => {
                        this.messages = response.data
                    })
            },
            watch: {
                newMember(){
                    axios.post('/team/{!! $team->name !!}/group-work/{!! $discipline->name !!}/{!! $groupWork->id !!}/{!! $subTeam->id !!}/newSubTeamMember/' + this.newMember.id)
                        .then(response => {
                            if(response.data == 'duplicate')
                                M.toast({html: 'Oh snap - duplicate member', classes: 'red'})
                            else{
                                this.members.push(response.data)
                                M.toast({html: 'Member successfully added', classes: 'green'})
                            }
                        })
                }
            },
            computed: {
                sortedMessages() {
                    return this.messages.sort((a, b) => -(a.id - b.id))
                }
            },
            methods: {
                sendMessage(){
                    if(this.message.text) {
                        axios.post('/team/{!! $team->name !!}/group-work/{!! $discipline->name !!}/{!! $groupWork->id !!}/{!! $subTeam->id !!}/newMessage', this.message)
                            .then(response => {
                                this.messages.push(response.data)
                                this.message.text = null
                            })
                    }
                },
                removeMember(id){
                    axios.post('/team/{!! $team->name !!}/group-work/{!! $discipline->name !!}/{!! $groupWork->id !!}/{!! $subTeam->id !!}/removeMember/'+id)
                        .then(response => {
                            location.reload()
                        })
                }
            }
        })
    </script>
@endsection
