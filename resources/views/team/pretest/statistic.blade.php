@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest-discipline-show-statistic', $team, $discipline, $pretest) }}
@endsection
@section('content')
    <div class="row" id="statistic">
        <div class="col s12">
            <div class="card-panel">
                {!! $chart->container() !!}
            </div>
        </div>
        <div class="col s12">
            <div class="card-panel">
                <table class="striped responsive-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th v-for="index in countQuestions">
                           Quest @{{ index }}
                        </th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(student, index) in statistic" v-if="student.passed">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ student.shortName }}</td>
                            <td v-for="question in student.questions">
                                <i class="material-icons" v-if="question.hasAnswer">done</i>
                                <i class="material-icons" v-else>close</i>
                            </td>
                            <th>@{{ student.countAnswers }}</th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}
    <script>
        new Vue({
            el: '#statistic',
            data: {
                statistic: [],
                countQuestions: [],
            },
            mounted() {
                axios.post('/team/{!! $team->name !!}/pretest/discipline/{!! $discipline->name !!}/{!! $pretest->id !!}/getStatistic')
                    .then(response => {
                        this.statistic = response.data
                        this.countQuestions = response.data[0].questions.length
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            }
        })
    </script>
@endsection