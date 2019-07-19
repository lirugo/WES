@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-group-work-show-sub-teams-sub-team', $team, $discipline, $groupWork, $subTeam) }}
@endsection
@section('content')
    <div id="sub-team-chat">
        <div class="progress m-t-0 red" v-if="isUploading">
            <div class="indeterminate orange"></div>
        </div>
        {{--Display team--}}
        <div class="row m-b-0">
            <div class="col s12">
                <div class="card-panel hoverable">
                    {!! Form::open(['url' => '/team/'.$team->name.'/group-work/'.$discipline->name.'/'.$groupWork->id.'/'.$subTeam->id.'/updateSubTeam']) !!}
                    <div class="row m-b-0">
                        {{--Name--}}
                        <div class="input-field col s12 m-b-0">
                            <input placeholder="@lang('app.Team Name')" id="name" name="name" type="text" value="{{$subTeam->name}}" class="validate" disabled>
                        </div>
                        <div class="input-field col s12 m4">
                            <input name="start_date" type="text" value="{{ json_decode($subTeam->getDeadline())->startDate }}" class="datepickerDefault" {{Auth::user()->hasRole(['teacher', 'manager']) ? '' : 'disabled'}}>
                            <span class="helper-text" data-error="wrong" data-success="right">@lang('app.Start Date')</span>
                        </div>
                        <div class="input-field col s12 m4">
                            <input name="end_date" type="text" value="{{ json_decode($subTeam->getDeadline())->endDate }}" class="datepickerDefault" {{Auth::user()->hasRole(['teacher', 'manager']) ? '' : 'disabled'}}>
                            <span class="helper-text" data-error="wrong" data-success="right">@lang('app.End Date')</span>
                        </div>
                        {{--Add new member--}}
                        @role('teacher')
                        @if(!$subTeam->isFinished())
                        <div class="input-field col s12 m4">
                            <select v-model="newMember">
                                <option value="" disabled selected>@lang('app.Add members')</option>
                                <option :value="student" v-for="student in students" :data-icon="'/uploads/avatars/'+student.avatar">@{{ student.name.second_name + ' ' + student.name.name }}</option>
                            </select>
                            <span class="helper-text" data-error="@lang('app.wrong')" data-success="@lang('app.All is OK')"></span>
                        </div>
                        @endif
                        @endrole
                    </div>
                    <div class="row m-b-0">
                        {{--Show members--}}
                        <div class="col s12 m6">
                            <table class="highlight responsive-table">
                                <thead>
                                <tr>
                                    <th>@lang('app.Student')</th>
                                    <th>@lang('app.Mark')</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(member, index) in members">
                                    <td>
                                        <div class="hoverable chip m-l-10">
                                        <img :src="'/uploads/avatars/' + member.user.avatar" alt="image">
                                        @{{member.user.name.second_name + ' ' + member.user.name.name}}
                                        @role('teacher')
                                            <i class="chip-icon material-icons" @click="removeMember(member.user.id)">close</i>
                                        @endrole
                                        </div>
                                    </td>
                                    <td>
                                        @if(Auth::user()->hasRole('teacher'))
                                            @if(!$subTeam->isFinished())
                                                <input type="number" placeholder="@lang('app.Set mark')" v-model="member.mark" @change="updateMark(member)"/>
                                            @else
                                            <input type="number" placeholder="@lang('app.Set mark')" v-model="member.mark" disabled/>
                                            @endif
                                        @else
                                            <input type="number" placeholder="@lang('app.Set mark')" v-model="member.mark" disabled/>
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(Auth::user()->hasRole(['teacher', 'manager']))
                        @if(!$subTeam->isFinished())
                            <button type="submit" class="waves-effect waves-light btn btn-small orange right">@lang('app.update')</button>
                        @endif
                    @endif
                    {!! Form::close() !!}

                    <br>
                    {{--Button for finish sub team--}}
{{--                    @role('teacher')--}}
{{--                    @if(!$subTeam->isFinished())--}}
{{--                        {!! Form::open(['route' => ['team.group-work.subteam.finish', $team->name, $discipline->name, $groupWork->id, $subTeam->id]]) !!}--}}
{{--                        <button type="submit" class="waves-effect waves-light btn btn-small red left tooltipped" data-position="bottom" data-tooltip="Press for closing sub team">Finish</button>--}}
{{--                        {!! Form::close() !!}--}}
{{--                    @endif--}}
{{--                    @endrole--}}
                    {{--Show if sub team is closed--}}
                    @if($subTeam->isFinished())
                        <a href="#" class="waves-effect waves-light btn btn-small red left tooltipped" data-position="bottom" data-tooltip="@lang('app.That sub team was be closed')"><i class="material-icons">lock</i></a>
                    @endif
                </div>
            </div>
        </div>
        {{--Chat--}}
        <div class="row">
            <div class="col s12">
                @if(!$subTeam->isFinished() && !$subTeam->hasMark(Auth::user()->id))
                {{--Create message--}}
                <div class="card-panel m-b-20">
                    <div class="input-field m-b-0">
                        <input id="text" name="text" placeholder="@lang('app.Write your message')" type="text" v-model="message.text" class="validate">
                    </div>
                    {{--Attach files--}}
                    <div class="row m-b-0">
                        <div v-for="(file, index) in message.files">
                            <div class="col s10 input-field m-b-0">
                                <i class="material-icons prefix">attachment</i>
                                <input placeholder="@lang('app.Write name of file')" name="file" id="file" type="text" v-model="message.files[index].name"
                                       class="validate" required>
                            </div>
                            <div class="input-field col s2 m-b-0">
                                <a href="#" @click="deleteRow(index)" class="left"><i class="material-icons prefix center-align icon-red">delete</i></a>
                            </div>
                            <div class="col s12 file-field input-field m-b-0">
                                <div class="btn indigo">
                                    <span>@lang('app.File')</span>
                                    <input type="file" :id="'upload-'+index" required>
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" placeholder="@lang('app.Upload file')" @change="uploadFile(index)"
                                           type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="btn-floating waves-effect waves-light red left tooltipped"
                       data-position="right" data-tooltip="@lang('app.Add more files')"
                       @click="addRow"><i
                                class="material-icons">add</i></a>
                    <a class="waves-effect waves-light btn btn-small indigo right" @click="sendMessage">@lang('app.send')</a>
                </div>
                @endif
                {{--Show Chat--}}
                <div class="card-panel" v-for="message in sortedMessages">
                    <div class="chip">
                        <img :src="'/uploads/avatars/' + message.author.avatar" alt="image">
                        @{{ message.author.name.second_name + ' ' + message.author.name.name }}
                    </div>
                    <p class="card-text">@{{ message.text }}</p>
                    {{--Files--}}
                    <div class="m-b-25" v-if="message.files != 0">
                        <div class="divider m-b-10"></div>
                        <div v-for="file in message.files">
                            <div class="row col m-r-10">
                                <form :action="'/team/group-work/getFile/'+file.file" method="POST">
                                    @csrf
                                    <button class="btn btn-small waves-effect waves-light indigo m-b-5" type="submit" name="action">
                                        @{{ file.name }}
                                        <i class="material-icons right">file_download</i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
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
                isUploading: false,
                message: {
                    text: null,
                    files: []
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
                                this.message.files = []
                            })
                    }
                },
                addRow() {
                    this.message.files.push({
                        file: null,
                        name: null
                    })
                },
                removeMember(id){
                    axios.post('/team/{!! $team->name !!}/group-work/{!! $discipline->name !!}/{!! $groupWork->id !!}/{!! $subTeam->id !!}/removeMember/'+id)
                        .then(response => {
                            location.reload()
                        })
                },
                uploadFile(index) {
                    let formData = new FormData()
                    this.isUploading = true
                    const parent = this;
                    formData.append('file', document.getElementById('upload-' + index).files[0]);
                    formData.append('label', 'subteam');
                    axios.post('/team/{!! $team->name !!}/group-work/store/file', formData,
                    ).then(function (response) {
                        parent.message.files[index].file = response.data
                        parent.isUploading = false
                    })
                        .catch(function () {
                            console.log('FAILURE!!');
                        });
                },
                updateMark(member){
                    axios.post('/team/{!! $team->name !!}/group-work/{!! $discipline->name !!}/{!! $groupWork->id !!}/{!! $subTeam->id !!}/subTeamUpdateMark/' + member.user.id, {'mark': member.mark})
                        .finally(() => {
                            M.toast({html: 'Mark was be updated', classes: 'green'})
                        })

                },
            }
        })
    </script>
@endsection
