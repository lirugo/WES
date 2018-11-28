@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest-discipline-show', $team, $discipline, $pretest) }}
@endsection
@section('content')
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
                        {!! Form::number('time', $pretest->time, ['placeholder' => 'Minutes', 'min' => 0, 'max' => 480, 'disabled']) !!}
                        <label for="time">Min for that test</label>
                    </div>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">title</i>
                    <input placeholder="Write name of pretest" name="name" id="name" type="text" class="validate"
                           value="{{$pretest->name}}" disabled>
                    <label for="name">Name</label>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">format_align_justify</i>
                    <textarea placeholder="Write description of pretest" name="description" id="description" type="text"
                              class="materialize-textarea" readonly>{{$pretest->description}}</textarea>
                    <label for="description">Description</label>
                </div>
                <div class="row">
                    {{--Start date&time picker--}}
                    <div class="input-field">
                        <i class="material-icons prefix">date_range</i>
                        <input id="start_date" value="{{$pretest->start_date}}" name="start_date" type="text"
                               class="datepickerDefault" disabled>
                        <label for="start_date">Start date</label>
                    </div>
                    {{--End date&time picker--}}
                    <div class="input-field">
                        <i class="material-icons prefix">date_range</i>
                        <input id="end_date" value="{{$pretest->end_date}}" name="end_date" type="text"
                               class="datepickerDefault" disabled>
                        <label for="end_date">End date</label>
                    </div>
                </div>
                <p>
                    <label>
                        <input type="checkbox" name="mark_in_journal" {{$pretest->mark_in_journal ? 'checked' : ''}}/>
                        <span>Mark in Journal</span>
                    </label>
                </p>
            </div>
        </div>
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
        <div class="col s12">
            <div class="card-panel">
                <div>
                    <input type="text" placeholder="Write the question" v-model="question.name" required/>
                    <div v-for="(answer, index) in question.answers">
                        <div class="row m-b-0 m-t-0">
                            <div class="input-field col s8 m10 m-b-0 m-t-0">
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
                <a class="btn-floating btn-small waves-effect waves-light red right" @click="deleteQuestion(question.id, index)"><i class="material-icons">delete</i></a>
            </div>
        </div>
    </div>
    <div class="fixed-action-btn">
        <a href="{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id.'/pass')}}" class="btn-floating btn-large green tooltipped" data-position="left"
           data-tooltip="Pass the Pretest">
            <i class="large material-icons">assignment_turned_in</i>
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
                addAnswer() {
                    this.question.answers.push({
                        answer: '',
                        isTrue: false
                    })
                },
                persistQuestion() {
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