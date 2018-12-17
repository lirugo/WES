@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-activity-pass', $team, $discipline, $activity) }}
@endsection
@section('content')
    {{--Show type activity--}}
    <div class="row m-b-0">
        <div class="col s12">
            <div class="card">
                <div>
                    <span data-badge-caption="" class="new badge left m-l-0">{{$activity->getType()}}</span>
                    @if($activity->mark_in_journal)
                        <span data-badge-caption="" class="new badge orange left">Max {{$activity->max_mark}} balls</span>
                    @endif
                </div>
                <div class="card-content">
                    <p class="card-title">{{$activity->name}}</p>
                    @if($activity->type == 'other')
                        <span><small>{{$activity->type_name}}</small></span>
                    @endif
                    <p><small>{{$activity->description}}</small></p>
                    <div class="m-t-10">
                        @if(count($activity->files))
                            @foreach($activity->files as $file)
                                {!! Form::open(['route' => ['team.activity.getFile', $file->file], 'method' => 'POST']) !!}
                                <button class="btn btn-small waves-effect waves-light indigo m-b-5" type="submit" name="action">{{$file->name}}
                                    <i class="material-icons right">file_download</i>
                                </button>
                                {!! Form::close() !!}
                            @endforeach
                        @endif
                    </div>
                    <small><blockquote class="m-b-0 m-t-15">Start date - {{$activity->start_date}}</blockquote></small>
                    <small><blockquote class="m-b-0 m-t-5">End date - {{$activity->end_date}}</blockquote></small>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-b-0">
        <div class="col s12">
            <div class="card-panel">
                {!! Form::open(['route' => ['team.activity.reply', $team->name, $activity->id, $student->id]]) !!}
                <div class="input-field">
                    <textarea id="text" name="text" class="materialize-textarea"></textarea>
                    <label for="text">Write your answer here</label>
                </div>
                <button type="submit" class="btn btn-small right indigo">Send</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="row" id="activityChat">
        <div class="col s12">
            <div class="card-panel" v-for="message in messages">
                {{--Image--}}
                <div class="chip" v-if="!message.teacher">
                    <img src="{{asset('/uploads/avatars/'.$student->avatar)}}" alt="{{$student->getShortName()}}">
                    {{$student->getShortName()}}
                </div>
                <div class="chip" v-else>
                    <img :src="'/uploads/avatars/' + message.teacher.avatar" alt="teacher">
                    Teacher
                </div>
                <div class="chip">
                    @{{ message.created_at }}
                </div>
                <p class="card-text">@{{ message.text }}</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#activityChat',
            data: {
                messages: [],
            },
            created(){
                //Get questions
                axios.post('/team/{!! $team->name !!}/activity/api/getMessages/{!! $activity->id !!}/{!! $student->id !!}')
                    .then(response => {
                        this.messages = response.data
                        console.log(response.data)
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            methods: {

            }
        })
    </script>
@endsection
