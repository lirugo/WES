@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-activity-show-students-pass', $team, $discipline, $activity, $student) }}
@endsection
@section('content')
    <div id="activityChat">
        <div class="progress m-t-0 red" v-if="isUploading">
            <div class="indeterminate orange"></div>
        </div>
        {{--Show type activity--}}
        <div class="row m-b-0">
            <div class="col s12">
                <div class="card">
                    <div>
                        <span data-badge-caption="" class="new badge left m-l-0">{{$activity->getType()}} фыв</span>
                        @if($activity->mark_in_journal)
                            <span data-badge-caption="" class="new badge orange left">@lang('app.Max') {{$activity->max_mark}} @lang('app.balls')</span>
                        @endif
                        @if($activity->getMark($student->id))
                            <span data-badge-caption="" class="new badge red right">@lang('app.Your mark') {{$activity->getMark($student->id)->mark}}</span>
                        @endif
                    </div>
                    <div class="card-content">
                        <p class="card-title">{{$activity->name}} | {{$student->getFullName()}}</p>
                        @if($activity->type == 'other')
                            <span><small>{{$activity->type_name}}</small></span>
                        @endif
                        <p>{!! $activity->description !!}</p>
                        <div class="m-t-10">
                            @if(count($activity->files))
                                @foreach($activity->files as $file)
                                    {!! Form::open(['route' => ['team.activity.getFile', $file->file], 'method' => 'POST']) !!}
                                    <button class="btn btn-small waves-effect waves-light indigo m-b-5" type="submit">{{$file->name}}
                                        <i class="material-icons right">file_download</i>
                                    </button>
                                    {!! Form::close() !!}
                                @endforeach
                            @endif
                        </div>
                        <small><blockquote class="m-b-0 m-t-15">@lang('app.Start date') - {{$activity->start_date}}</blockquote></small>
                        <small><blockquote class="m-b-0 m-t-5">@lang('app.End date') - {{$activity->end_date}}</blockquote></small>
                        @role(['manager','teacher'])
                        {!! Form::open(['route' => ['team.activity.pass.mark', $team->name, $discipline->name, $activity->id, $student->id]]) !!}
                        <div class="row m-b-0">
                            <div class="input-field col s6 m3">
                                <input type="number" min="0" max="{{  $activity->max_mark }}" name="mark" class="validate" required placeholder="@lang('app.Set mark for') {{$student->getShortName()}}"/>
                            </div>
                            <div class="input-field col s6 m3">
                                <button type="submit" class="btn btn-small indigo">@lang('app.Set')</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        @endrole
                    </div>
                </div>
            </div>
        </div>
        {{--New message--}}
        @role(['teacher', 'student', 'manager'])
        <div class="row m-b-0">
            <div class="col s12">
                <div class="card-panel">
                    {{--Text of answer--}}
                    <label id="new-message-label" class="red-text"></label>
                    <div class="input-field m-b-0">
                        <textarea id="text" name="text" class="materialize-textarea" v-model="message.text" required></textarea>
                        <label for="text">@lang('app.Write your answer here')</label>
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
                       data-position="right" data-tooltip="Add more files"
                       @click="addRow"><i
                                class="material-icons">add</i></a>
                    <button type="submit" class="btn btn-small right indigo waves-effect waves-light" @click="send" :disabled="isUploading">@lang('app.Send')</button>
                </div>
            </div>
        </div>
        @endrole
        {{--Chat--}}
        <div class="row">
            <div class="col s12">
                <div class="card-panel" v-for="message in messages">
                    {{--Image--}}
                    <div class="chip" v-if="!message.teacher">
                        <img src="{{asset('/uploads/avatars/'.$student->avatar)}}" alt="{{$student->getShortName()}}">
                        {{$student->getShortName()}}
                    </div>
                    <div class="chip" v-else>
                        <img :src="'/uploads/avatars/' + message.teacher.avatar" alt="teacher">
                        @lang('app.Teacher')
                    </div>
                    <div class="chip">
                        @{{ message.created_at }}
                    </div>
                    {{--Text--}}
                    <p class="card-text">@{{ message.text }}</p>
                    {{--Files--}}
                    <div class="m-b-25" v-if="message.files != 0">
                        <div class="divider m-b-10"></div>
                        <div v-for="file in message.files">
                            <div class="row col m-r-10">
                                <form :action="'/team/activity/getFile/'+file.file" method="POST">
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
            el: '#activityChat',
            data: {
                messages: [],
                message: {
                    text: null,
                    files: [],
                },
                isUploading: false
            },
            created(){
                //Get questions
                axios.post('/team/{!! $team->name !!}/activity/api/getMessages/{!! $activity->id !!}/{!! $student->id !!}')
                    .then(response => {
                        this.messages = response.data
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            methods: {
                send(){
                    if(this.message.text) {
                        axios.post('/team/{!! $team->name !!}/activity/api/send/{!! $activity->id !!}/{!! $student->id !!}', this.message)
                            .then(response => {
                                this.messages.unshift(response.data)
                                this.message.text = ''
                                this.message.files = []
                            })
                            .catch(e => {
                                this.errors.push(e)
                            })
                        document.getElementById('new-message-label').innerText = ''
                    }else{
                        document.getElementById('new-message-label').innerText = 'Field is required'
                    }
                },
                addRow() {
                    this.message.files.push({
                        file: null,
                        name: null
                    })
                },
                deleteRow(index) {
                    this.message.files.splice(index, 1)
                },
                uploadFile(index) {
                    let formData = new FormData()
                    this.isUploading = true
                    const parent = this;
                    formData.append('file', document.getElementById('upload-' + index).files[0]);
                    axios.post('/team/{!! $team->name !!}/activity/store/file', formData,
                    ).then(function (response) {
                        parent.message.files[index].file = response.data
                        parent.isUploading = false
                    })
                        .catch(function () {
                            console.log('FAILURE!!');
                        });
                },
            }
        })
    </script>
@endsection
