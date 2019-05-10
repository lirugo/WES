@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest-discipline-show', $team, $discipline, $pretest) }}
@endsection
@section('content')
    {!! Form::open(['route' => ['team.pretest.update',$team->name, $discipline->name, $pretest->id], 'method' => 'PUT']) !!}
    <div class="row">
        <div class="col s12 l6">
            <div class="card-panel">
                <div class="row m-b-0">
                    <div class="input-field col s12 m8">
                        <select name="discipline_id" disabled>
                            <option value="" disabled>Choose a discipline</option>
                            <option value="{{$discipline->id}}">{{$discipline->display_name}}</option>
                        </select>
                        <label for="discipline_id">Discipline</label>
                    </div>
                    <div class="input-field col s12 m4">
                        {!! Form::number('time', $pretest->time, ['placeholder' => 'Minutes', 'min' => 0, 'max' => 480, 'required']) !!}
                        <label for="time">Min for that test</label>
                    </div>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">title</i>
                    <input placeholder="Write name of pretest" name="name" id="name" type="text" class="validate"
                           value="{{$pretest->name}}" required>
                    <label for="name">Name</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">format_align_justify</i>
                    <textarea placeholder="Write description of pretest" name="description" id="description" type="text"
                              class="materialize-textarea" required>{{$pretest->description}}</textarea>
                    <label for="description">Description</label>
                </div>
                <div class="row">
                    {{--Start date&time picker--}}
                    <div class="input-field col s6">
                        <i class="material-icons prefix">date_range</i>
                        <input id="start_date" value="{{Carbon\Carbon::parse($pretest->start_date)->format('Y-m-d')}}" name="start_date" type="text"
                               class="datepickerDefault" required>
                        <label for="start_date">Start date</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="start_time" value="{{Carbon\Carbon::parse($pretest->start_date)->format('H:i')}}" name="start_time" type="text"
                               class="timepicker" required>
                        <label for="start_time">Time</label>
                    </div>
                    {{--End date&time picker--}}
                    <div class="input-field col s6">
                        <i class="material-icons prefix">date_range</i>
                        <input id="end_date" value="{{Carbon\Carbon::parse($pretest->end_date)->format('Y-m-d')}}" name="end_date" type="text"
                               class="datepickerDefault" required>
                        <label for="end_date">End date</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="end_time" value="{{Carbon\Carbon::parse($pretest->end_date)->format('H:i')}}" name="end_time" type="text"
                               class="timepicker" required>
                        <label for="end_time">Time</label>
                    </div>
                </div>
                <p>
                    <label>
                        <input type="checkbox" name="mark_in_journal" {{$pretest->mark_in_journal ? 'checked' : ''}}/>
                        <span>Mark in Journal</span>
                    </label>
                </p>
{{--                @if($pretest->isEditable())--}}
                    <button type="submit" class="btn btn-small right orange">Update Deadline</button>
{{--                @endif--}}
            </div>
        </div>
    {!! Form::close() !!}
        <div class="col s12 l6">
            @foreach($pretest->files as $file)
                <div class="card-panel">
                    {!! Form::open(['route' => ['team.pretest.getFile', $file->file], 'method' => 'POST']) !!}
                    <button class="btn waves-effect waves-light indigo" type="submit" name="action">{{$file->name}}
                        <i class="material-icons right">file_download</i>
                    </button>
                    {!! Form::close() !!}
                </div>
            @endforeach
        </div>
    </div>

    <div class="row" id="pretest-question">
        {{--Block add question--}}
        @if($pretest->isEditable())
        <div class="col s12">
            <div class="card-panel">
                <div>
                    <input type="text" placeholder="Write the question" v-model="question.name" required/>
                    <div v-for="(answer, index) in question.answers">
                        <div class="row m-b-0 m-t-0">
                            <a class="btn-floating btn-small waves-effect waves-light red left m-t-10" @click="deleteAnswer(answer, index)"><i class="material-icons">delete</i></a>
                            <div class="input-field col s8 m9 m-b-0 m-t-0">
                                <input type="text" v-model="question.answers[index].answer" placeholder="Write the answer" required/>
                            </div>
                            <div class="input-field col s4 m2 m-b-0 m-t-0">
                                <label>
                                    <input type="checkbox" v-model="question.answers[index].isTrue" />
                                    <span>Answer</span>
                                </label>

                            </div>
                        </div>
                    </div>
                </div>
                <a class="btn-floating btn-large waves-effect waves-light green left" @click="addAnswer"><i class="material-icons">add</i></a>
                <a class="btn-floating btn-large waves-effect waves-light green right" @click="persistQuestion"><i class="material-icons">save</i></a>
            </div>
        </div>
        @endif
        {{--Block show question--}}
        <div class="col s12 m6" v-for="(question, index) in questions">
            <div class="card-panel">
                <input type="text" value="" v-model="question.name" disabled/>
                <div class="row m-b-0 m-t-0" v-for="(answer, index) in question.answers">
                    <div class="input-field col s8 m-b-0 m-t-0">
                        <input type="text" value="" v-model="answer.name" disabled/>
                    </div>
                    <div class="input-field col s4 m-b-0 m-t-0">
                        <label>
                            <input type="checkbox" v-model="answer.is_answer" disabled />
                            <span>Answer</span>
                        </label>
                    </div>
                </div>
                @if($pretest->isEditable())
                    <a class="btn-floating btn-small waves-effect waves-light red right" @click="deleteQuestion(question.id, index)"><i class="material-icons">delete</i></a>
                @endif
            </div>
        </div>
    </div>
    <div class="fixed-action-btn">
        <a href="{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id.'/statistic')}}" class="btn-floating btn-large orange tooltipped" data-position="left"
           data-tooltip="Open Statistics">
            <i class="large material-icons">storage</i>
        </a>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#pretest-question',
            data: {
                questions: [],
                question: {
                    name: '',
                    answers: [
                        {
                            answer: '',
                            isTrue: false
                        }
                    ]
                }
            },
            created() {
                axios.post('/team/{!! $team->name !!}/pretest/discipline/{!! $discipline->name !!}/{!! $pretest->id !!}/question')
                    .then(response => {
                        this.questions = response.data
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            methods: {
                deleteAnswer(answer, index) {
                    if(index != 0)
                        this.question.answers.splice(index, 1)
                },
                addAnswer() {
                    if(this.question.answers[this.question.answers.length - 1].answer != '')
                        this.question.answers.push({
                            answer: '',
                            isTrue: false
                        })
                },
                persistQuestion() {
                    if(this.question.answers[this.question.answers.length - 1].answer != '')
                        axios.put('/team/{!! $team->name !!}/pretest/discipline/{!! $discipline->name !!}/{!! $pretest->id !!}/question', this.question)
                            .then(response => {
                                this.questions.push(response.data)
                                this.question.name = ''
                                this.question.answers = [
                                    {
                                        answer: '',
                                        isTrue: false
                                    }
                                ]
                            })
                            .catch(e => {
                                this.errors.push(e)
                            })
                },
                deleteQuestion(id, index) {
                    axios.delete('/team/{!! $team->name !!}/pretest/discipline/{!! $discipline->name !!}/{!! $pretest->id !!}/question/' + id, {id: id})
                        .then(response => {
                            this.questions.splice(index, 1)
                        })
                        .catch(e => {
                            this.errors.push(e)
                        })
                }
            }
        });
    </script>
@endsection