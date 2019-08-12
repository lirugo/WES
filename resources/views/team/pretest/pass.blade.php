@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest-discipline-show-pass', $team, $discipline, $pretest) }}
@endsection
@section('style')
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
@endsection
@section('content')
    <widget-countdown
            :time="time"
            :end-time="endTimer"
            ></widget-countdown>
    <v-app class="grey lighten-3">
        <v-content>
            <v-container>
                <v-tabs class="hoverable"
                        v-model="active"
                        color="indigo"
                        dark
                        slider-color="orange"
                >
                    <v-tab
                            v-for="(question, index) in questions"
                            :key="index"
                            ripple
                    >
                        @lang('app.Question') @{{ index + 1 }}
                    </v-tab>
                    <v-tab-item
                            v-for="question in questions"
                            :key="question.id"
                    >
                        <v-card flat>
                            <v-card-text>
                                <v-textarea
                                        name="input-7-1"
                                        label="Question"
                                        :value="question.name"
                                        hint="Hint text"
                                        disabled
                                ></v-textarea>

                                <v-checkbox class="ma-0"
                                            v-for="answer in question.answers"
                                            :key="answer.id"
                                            :label="`${ answer.name }`"
                                            v-model="answer.is_answer"
                                            @change="checked(question.id, answer.id, answer.is_answer)"
                                ></v-checkbox>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                </v-tabs>
                <div class="text-xs-center right mt-3">
                    <v-btn @click="next" v-if="!isFinish">next</v-btn>
                    <v-btn @click="passPretest" class="green white-text" v-else>finish</v-btn>
                </div>
                <v-dialog
                        v-model="dialog"
                        persistent
                        width="500px"
                >
                    <v-card>
                        <v-card-title
                                class="headline orange center white-text"
                                primary-title
                        >
                            @lang('app.Pretest result')
                        </v-card-title>

                        <v-card-text>
                            @lang('app.Correct answers') - @{{ countAnswers }} | @{{ Math.round(countAnswers / questions.length * 100) }} %
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                    color="primary"
                                    flat
                                    @click="accepted"
                            >
                                @lang('app.Close')
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-container>
        </v-content>
    </v-app>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vuetify@1.x/dist/vuetify.js"></script>
    <script>
        function getIndex(array, id) {
            for (var i = 0; i < array.length; i++) {
                if (array[i]['questionId'] == id) {
                    return i;
                }
            }
            return null;
        }

        new Vue({
            el: '#app',
            data: {
                active: null,
                isFinish: false,
                questions: [],
                answers: [],
                dialog: false,
                countAnswers: 0,
                time: '{!! $pretest->time !!}' * 60
            },
            created() {
                //Get questions
                axios.post('/team/{!! $team->name !!}/pretest/discipline/{!! $discipline->name !!}/{!! $pretest->id !!}/question')
                    .then(response => {
                        this.questions = response.data
                        this.questions.forEach(function(question, i, questions) {
                            question.answers.forEach(function(answer, i, answers) {
                                answer.is_answer = false
                            })
                        })
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
                //Set start pretest
                axios.post('/team/{!! $team->name !!}/pretest/discipline/{!! $discipline->name !!}/{!! $pretest->id !!}/start')
                    .catch(e => {
                        this.errors.push(e)
                    })
            },
            methods: {
                endTimer(){
                    this.time = 0
                    this.passPretest()
                },
                next () {
                    const active = parseInt(this.active)
                    const countQuestions = this.questions.length - 1
                    if(active <= countQuestions)
                        this.active++

                    if(active == countQuestions - 1)
                        this.isFinish = true
                },
                accepted() {
                    window.history.back()
                },
                passPretest() {
                    axios.post('/team/{!! $team->name !!}/pretest/discipline/{!! $discipline->name !!}/{!! $pretest->id !!}/checking', this.answers)
                        .then(response => {
                            this.dialog = true
                            this.countAnswers = response.data.countAnswers
                        })
                        .catch(e => {
                            this.errors.push(e)
                        })
                },
                checked(questionId, answerId, checked){
                    if(checked) {
                        anotherAnswer = this.answers.filter(answer => {
                            return answer.questionId == questionId
                        })
                        if(anotherAnswer == 0)
                            this.answers.push({
                                'questionId': questionId,
                                'answers': [answerId]
                            })
                        else {
                            anotherAnswer[0].answers.push(answerId);
                            let index = getIndex(this.answers, questionId)
                            this.answers.splice(index, 1, anotherAnswer[0])
                        }
                    }
                    else {
                        anotherAnswer = this.answers.filter(answer => {
                            return answer.questionId == questionId
                        })
                        anotherAnswer[0].answers = anotherAnswer[0].answers.filter(answer => {
                            return answer != answerId
                        })
                        let index = getIndex(this.answers, questionId)
                        this.answers.splice(index, 1, anotherAnswer[0])
                    }
                }
            },
        })
    </script>
@endsection
