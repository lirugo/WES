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
                            <td class="center-align">Students | Start date of activities and pretests</td>
                            @foreach($commonActDates as $d)
                                <td class="center-align">
                                    <a href="#" class="tooltipped" data-position="top" data-tooltip="{{$d['activityName']}}">
                                        <small>{{$d['actDate']}}</small>
                                    </a>
                                </td>
                            @endforeach
                            <td class="center-align">
                                <small>Total</small>
                            </td>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i=0; $i<count($common);)
                            <tr>
                                <td>
                                    <small>{{$common[$i]['student']}}</small>
                                </td>
                                <?php $total = 0;?>
                                @for($j=0; $j<count($commonActDates); $j++)
                                    <td class="center-align">
                                        @if($common[$i]['type'] == 'activity')
                                            <a target="_blank" href="{{url('/team/'.$team->name.'/activity/'.$discipline->name.'/pass/'.$common[$i]['activityId'].'/'.$common[$i]['studentId'])}}">
                                                {{$common[$i]['mark']}}
                                            </a>
                                        @elseif($common[$i]['type'] == 'pretest')
                                            <a target="_blank" href="{{url('/team/'.$team->name.'/pretest/discipline/'.$discipline->name)}}">
                                                {{$common[$i]['mark']}}
                                            </a>
                                        @endif
                                    </td>
                                    <?php
                                        $total += $common[$i]['mark'];
                                        $i++;
                                    ?>
                                    @if(($j + 1) >= count($commonActDates))
                                        <td class="center-align">{{$total}}</td>
                                    @endif
                                @endfor
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
