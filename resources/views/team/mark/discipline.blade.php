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
                                    <a href="#" class="tooltipped" data-position="top" data-tooltip="{{$act->name}}">
                                        <small>{{\Carbon\Carbon::parse($act->start_date)->format('d-m-Y')}}</small>
                                    </a>
                                </td>
                            @endforeach
                            @foreach($pretests as $test)
                                <td class="center-align">
                                    <a href="#" class="tooltipped" data-position="top" data-tooltip="{{$test->name}}">
                                        <small>{{\Carbon\Carbon::parse($test->start_date)->format('d-m-Y')}}</small>
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
                                    <small>{{$student->getShortName()}}</small>
                                </td>
                                @foreach($activities as $act)
                                    <td class="center-align">
                                        <a target="_blank" href="{{url('/team/'.$team->name.'/activity/'.$discipline->name.'/pass/'.$act->id.'/'.$student->id)}}">
                                            {{$act->getMark($student->id) ? $act->getMark($student->id)->mark : '-'}}
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
                                        <a target="_blank" href="{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name)}}">
                                            {{$test->getMark($student->id) ? $test->getMark($student->id)->mark : '-'}}
                                            @if($test->getMark($student->id))
                                            <?php
                                                $total += $test->getMark($student->id)->mark;
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
@endsection
