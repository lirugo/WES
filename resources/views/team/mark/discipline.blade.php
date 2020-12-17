@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-mark-discipline', $team, $discipline) }}
@endsection
@section('content')
    <div class="row" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <table class="responsive-table">
                        <col width="200px">
                        <thead>
                        <tr>
                            <td class="center-align">@lang('app.Students') | @lang('app.Start date of activities and pretests')</td>
                            @foreach($activities as $act)
                                <td class="center-align">
                                    <span data-badge-caption="" class="new badge orange">@lang('app.Max') {{$act->max_mark}}</span>
                                    <br/>
                                    <a href="#" class="tooltipped" data-position="top" data-tooltip="Activity - {{$act->name}}">
                                        <small>{{\Carbon\Carbon::parse($act->start_date)->format('d-m-Y')}}</small>
                                    </a>
                                </td>
                            @endforeach
                            @foreach($pretests as $test)
                                <td class="center-align">
                                    <a href="#" class="tooltipped" data-position="top" data-tooltip="Pretest - {{$test->name}}">
                                        <small>{{\Carbon\Carbon::parse($test->start_date)->format('d-m-Y')}}</small>
                                    </a>
                                </td>
                            @endforeach
                            @foreach($groupWorks as $work)
                                <td class="center-align">
                                    <a href="#" class="tooltipped" data-position="top" data-tooltip="Group Work - {{$work->name}}">
                                        <small>{{\Carbon\Carbon::parse($work->start_date)->format('d-m-Y')}}</small>
                                    </a>
                                </td>
                            @endforeach
                            <td class="center-align">
                                <small>@lang('app.Total')</small>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $student)
                            <?php
                                $total = 0;
                            ?>
                            <tr>
                                <td>
                                    <small>{{$student->getFullName()}}</small>
                                </td>
                                @foreach($activities as $act)
                                    <td class="center-align">
                                        @role(['manager','teacher'])
                                            <input type="number" class="validate" style="max-width: 50px; text-align:center;"  value="{{$act->getMark($student->id) ? $act->getMark($student->id)->mark : ''}}"
                                                   onchange="updateActivityMark(this.value, {{$team->id}}, {{$act->id}}, {{$student->id}})"/>
                                        @endrole

                                        @role('student')
                                            <input type="number" class="validate" style="max-width: 50px; text-align:center;"  value="{{$act->getMark($student->id) ? $act->getMark($student->id)->mark : ''}}" disabled/>
                                        @endrole
                                        <a target="_blank" class="tooltipped" data-position="top" data-tooltip="Open" href="{{url('/team/'.$team->name.'/activity/'.$discipline->name.'/pass/'.$act->id.'/'.$student->id)}}">
                                            <i class="material-icons">arrow_forward</i>

                                            @if($act->getMark($student->id))
                                                <?php
                                                    $total += $act->getMark($student->id)->mark;
                                                    ?>
                                            @endif
                                        </a>
                                    </td>
                                @endforeach

                                @foreach($pretests as $test)
                                    <td class="center-align">
                                        @role(['manager','teacher'])
                                        <input type="number" class="validate" style="max-width: 50px; text-align:center;"  value="{{$test->getMark($student->id) ? $test->getMark($student->id)->mark : ''}}"
                                               onchange="updatePretestMark(this.value, {{$team->id}}, {{$test->id}}, {{$student->id}})"/>
                                        @endrole

                                        @role('student')
                                            <input type="number" class="validate" style="max-width: 50px; text-align:center;"  value="{{$test->getMark($student->id) ? $test->getMark($student->id)->mark : ''}}" disabled/>
                                        @endrole
                                        <a target="_blank" href="{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name)}}">
                                            <i class="material-icons">arrow_forward</i>
                                            @if($test->getMark($student->id))
                                                <?php
                                                $total += $test->getMark($student->id)->mark;
                                                ?>
                                            @endif
                                        </a>
                                    </td>
                                @endforeach

                                @foreach($groupWorks as $work)
                                    <td class="center-align">
                                        @role(['manager','teacher'])
                                            <input type="number" class="validate" style="max-width: 50px; text-align:center;"  value="{{$work->getMark($student->id) ? $work->getMark($student->id)->mark : ''}}"
                                                   onchange="updateGroupWorkMark(this.value, {{$team->id}}, {{$work->id}}, {{$student->id}})"
                                                    {{!$work->getMark($student->id) ? 'disabled' : ''}}
                                            />
                                        @endrole
                                        @role('student')
                                            <input type="number" class="validate" style="max-width: 50px; text-align:center;"  value="{{$work->getMark($student->id) ? $work->getMark($student->id)->mark : ''}}" disabled/>
                                        @endrole
                                        <a target="_blank" href="{{url('/team/'.$team->name.'/group-work/'.$discipline->name.'/'.$work->id)}}">
                                            <i class="material-icons">arrow_forward</i>
                                            @if($work->getMark($student->id))
                                                <?php
                                                $total += $work->getMark($student->id)->mark;
                                                ?>
                                            @endif
                                        </a>
                                    </td>
                                @endforeach
                                <td class="center-align">{{$total}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        function updateActivityMark(mark, teamId, activityId, studentId) {
            axios.post('/team/api/updateActivityMark', {
                'mark': mark,
                'teamId': teamId,
                'activityId': activityId,
                'studentId': studentId,
            })
            .then(res => {
                M.toast({html: 'Mark updated', classes: 'green'})
            })
        }
        function updatePretestMark(mark, teamId, activityId, studentId) {
            axios.post('/team/api/updatePretestMark', {
                'mark': mark,
                'teamId': teamId,
                'activityId': activityId,
                'studentId': studentId,
            })
            .then(res => {
                M.toast({html: 'Mark updated', classes: 'green'})
            })
        }
        function updateGroupWorkMark(mark, teamId, activityId, studentId) {
            axios.post('/team/api/updateGroupWorkMark', {
                'mark': mark,
                'teamId': teamId,
                'activityId': activityId,
                'studentId': studentId,
            })
            .then(res => {
                M.toast({html: 'Mark updated', classes: 'green'})
            })
        }
    </script>
@endsection
