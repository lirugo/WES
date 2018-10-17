@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-mark-discipline-task-create', $team, $discipline->getDiscipline) }}
@endsection
@section('content')
    {!! Form::open(['route' => ['team.mark.discipline.task.store', $team->name, $discipline->getDiscipline->name], 'method' => 'POST']) !!}
    <div class="row">
        <div class="col s12 l6">
            <div class="card-panel hoverable" id="check_has_term">
                <div class="input-field m-b-0">
                    <i class="material-icons prefix">group</i>
                    <input placeholder="Name" name="name" value="{{old('name')}}" type="text" class="validate" required>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">home</i>
                    @if(count($discipline->getHomeWork()))
                        <select name="homework_id">
                            <option value="" disabled selected>Choose Homework</option>
                            @foreach($discipline->getHomeWork() as $homeWork)
                            <option {{ old('homework_id') == $homeWork->id ? 'selected' : '' }} value="{{$homeWork->id}}">{{$homeWork->display_name}}</option>
                            @endforeach
                        </select>
                    @else
                        <select name="homework_id" disabled>
                            <option value="" disabled selected>No Homeworks</option>
                        </select>
                    @endif
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">bookmark_border</i>
                    <input placeholder="Max mark" name="max_mark" type="number" value="{{old('max_mark')}}" class="validate" min="1" max="100" step="1" required>
                </div>
                <div class="input-field">
                    <i class="material-icons prefix">mode_edit</i>
                    <textarea name="description" placeholder="Description" class="materialize-textarea">{{old('description')}}</textarea>
                </div>
                <p>
                    <label>
                        <input type="checkbox" name="has_term" v-model="has_term" />
                        <span>Has Term</span>
                    </label>
                </p>
                <div class="row  m-t-0 m-b-0" v-if="has_term">
                    <div class="input-field col s12 l6  m-t-0 m-b-0">
                        <i class="material-icons prefix">date_range</i>
                        <input type="text" name="start_date" placeholder="Start Date" value="{{old('start_date')}}" class="datepicker" required>
                    </div>
                    <div class="input-field col s12 l6  m-t-0 m-b-0">
                        <i class="material-icons prefix">date_range</i>
                        <input type="text" name="end_date" placeholder="End Date" value="{{old('end_date')}}" class="datepicker" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12 l6" id="generate_number">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title">{{$discipline->getDiscipline->display_name}}</span>
                    <div class="row m-b-0">
                        <div class="input-field col s12 l6 m-t-20">
                            <p class="center-align">Free points</p>
                            <p class="center-align card-title red-text"><strong>{{100 -$discipline->getCountPoints()}}</strong></p>
                        </div>
                        <div class="input-field col s12 l6 m-t-20">
                            <label>Task Auto-Generate Number</label>
                            <input readonly placeholder="Task Number" id="number" name="number" v-model="number" type="text" class="center-align green white-text m-t-5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Floating button--}}
    <div class="fixed-action-btn">
        <button type="submit" class="btn-floating btn-large green tooltipped" data-position="left" data-tooltip="Save">
            <i class="large material-icons">save</i>
        </button>
    </div>
    {!! Form::close() !!}
    <div class="row">
        <div class="col s12">
            <div class="card-panel hoverable">
                <table class="striped responsive-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Task</th>
                        <th>Max Mark</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($discipline->getTasks as $task)
                        <tr>
                            <td>{{$task->name}}</td>
                            <td>{{$task->number}}</td>
                            <td>{{$task->homework ? $task->homework->display_name : $task->name}}</td>
                            <td>{{$task->max_mark}}</td>
                            <td>{{$task->description}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
       new Vue({
           el:'#generate_number',
            data: {
                number: Math.floor(Math.random() * (999999 - 1 + 1)) + 1,
            }
        });
       new Vue({
           el:'#check_has_term',
            data: {
                has_term: true
            }
        })
    </script>
@endsection
