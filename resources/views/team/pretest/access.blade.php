@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest-discipline-show-access', $team, $discipline, $pretest) }}
@endsection
@section('content')
    <div class="row">
        @if(Auth::user()->hasRole('manager'))
        <div class="col s12">
            <div class="card-panel">
                {!! Form::open(['route' => ['team.pretest.updateEndDate',$team->name, $discipline->name, $pretest->id], 'method' => 'PUT']) !!}
                {{--End date&time picker--}}
                <div class="row m-b-0">
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
                    <button type="submit" class="btn btn-small right orange">Update</button>
                {!! Form::close() !!}
            </div>
        </div>
        @endif
        <div class="col s12">
            <div class="card-panel">
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Access</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($team->getStudents() as $student)
                        <tr>
                            <td>{{$student->getShortName()}}</td>
                            <td>
                                @if($pretest->hasAccess($student->id))
                                    <i class="material-icons">lock_open</i>
                                @else
                                    <i class="material-icons">lock</i>
                                @endif
                            </td>
                            <td>
                                @if($pretest->hasAccess($student->id))
                                    {{--//--}}
                                @else
                                    {!! Form::open(['url' => '/team/'.$team->name.'/pretest/discipline/'.$discipline->name.'/'.$pretest->id.'/setAccess']) !!}
                                        <input type="hidden" value="{{$student->id}}" name="student_id"/>
                                        <button type="submit" class="waves-effect waves-light btn btn-small orange"><i class="material-icons right">lock_open</i>Open</button>
                                    {!! Form::close() !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection