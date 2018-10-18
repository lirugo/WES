@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-mark-discipline', $team, $discipline) }}
@endsection
@section('content')
    <div class="row" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <table class="striped" id="log">
                        <col width="150px">
                        @foreach($team->getDiscipline($discipline->id)->getTasks as $task)
                        <col width="45px">
                        @endforeach
                        <col width="45px">
                        <thead>
                            <tr>
                                <th>Student | Task</th>
                                @foreach($team->getDiscipline($discipline->id)->getTasks as $task)
                                    <th class="center-align"><span class="vertical-rl">#{{$task->number}}</span></th>
                                @endforeach
                                <th class="center-align"><span class="vertical-rl">Total</span></th>
                                <th class="center-align"></th>
                            </tr>
                        </thead>
                        <tbody>
                        {{--TODO:: Check it--}}
                        @foreach($team->getStudents() as $student)
                            <tr>
                                <td>{{$student->getShortName()}}</td>
                                <?php $total = 0; ?>
                                @foreach($team->getDiscipline($discipline->id)->getTasks as $task)
                                    @if($task->getMark($student->id))
                                        <td class="center-align">
                                            <input name="mark" value="{{$task->getMark($student->id)->mark}}" type="number" min="1" max="100" step="1" v-on:change="update(this)"/>
                                        </td>
                                        <?php $total += $task->getMark($student->id)->mark ?>
                                    @else
                                        <td class="center-align">
                                            <input name="mark" type="number" min="1" max="100" step="1" v-on:change="update(this)"/>
                                        </td>
                                    @endif
                                @endforeach
                                <td class="center-align">{{$total ? $total : ''}}</td>
                                <td class="center-align"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large green tooltipped" href="{{url('/team/'.$team->name.'/mark/'.$discipline->name.'/task/create')}}" data-position="left" data-tooltip="Create Task">
            <i class="large material-icons">add</i>
        </a>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#log',
            methods: {
                update: function (mark){
                    console.log(mark);
                }
            }
        })
    </script>
@endsection
