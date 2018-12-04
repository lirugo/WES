@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-pretest-discipline-show-access', $team, $discipline, $pretest) }}
@endsection
@section('content')
    <div class="row">
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