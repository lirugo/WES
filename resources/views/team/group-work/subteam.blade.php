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
                    {!! Form::open(['url' => '/team/'.$team->name.'/group-work/'.$discipline->name.'/'.$groupWork->id.'/'.$subTeam->id.'/updateSubTeam']) !!}
                    <div class="row m-b-0">
                        {{--Name--}}
                        <div class="input-field col s12 m-b-0">
                            <input placeholder="Team Name" id="name" name="name" type="text" value="{{$subTeam->name}}" class="validate" disabled>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="start_date" type="text" value="{{ json_decode($subTeam->getDeadline())->startDate }}" class="datepickerDefault">
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="end_date" type="text" value="{{ json_decode($subTeam->getDeadline())->endDate }}" class="datepickerDefault">
                        </div>
                        {{--Show members--}}
                        @foreach($subTeam->members as $member)
                            <div class="chip m-l-10">
                                <img src="/uploads/avatars/{{$member->user->avatar}}" alt="image">
                                {{$member->user->name->second_name.' '.$member->user->name->name}}
                            </div>
                        @endforeach
                    </div>
                    @if(Auth::user()->hasRole(['teacher', 'manager']))
                        <button type="submit" class="waves-effect waves-light btn btn-small orange right">update</button>
                    @endif
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        {{--Chat--}}
        <div class="row" id="sub-team-chat">
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
                messages: []
            },
            created(){
                axios.post('/team/{!! $team->name !!}/group-work/{!! $discipline->name !!}/{!! $groupWork->id !!}/{!! $subTeam->id !!}/getMessages')
                    .then(response => {
                        this.messages = response.data
                    })
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
                }
            }
        })
    </script>
@endsection
