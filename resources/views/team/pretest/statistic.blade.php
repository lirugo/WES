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
                        <th>Name</th>
                        <th v-for="index in countQuestions">
                            Quest @{{ index }}
                        </th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td>{{ $student->shortName }}</td>
                            @foreach($student->questions as $question)
                                <td>
                                    @if($question->hasAnswer)
                                        <i class="material-icons">done</i>
                                    @else
                                        <i class="material-icons">close</i>
                                    @endif
                                </td>
                            @endforeach
                            <th>{{ $student->countAnswers }}</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if(Auth::user()->hasRole('manager'))
            <div class="fixed-action-btn">
                <a href="{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id.'/access')}}" class="btn-floating btn-large orange tooltipped" data-position="left"
                   data-tooltip="Access">
                    <i class="large material-icons">lock</i>
                </a>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}
    <script>
        new Vue({
            el: '#statistic',
            data: {
                statistic: {!! $students !!},
                countQuestions: [],
            },
            computed: {
            },
            mounted() {
                axios.post('/team/{!! $team->name !!}/pretest/discipline/{!! $discipline->name !!}/{!! $pretest->id !!}/getStatistic')
                    .then(response => {
                        this.statistic = response.data
                        console.log(response.data)
                        this.countQuestions = response.data[0].questions.length
                    })
                    .catch(e => {
                        this.errors.push(e)
                    })
            }
        })
    </script>
@endsection