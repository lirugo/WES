@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-mark', $team) }}
@endsection
@section('content')
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <table class="responsive-table" id="log">
                        <col width="150px">
                        @foreach($commonStudents as $s)
                            <col width="45px">
                        @endforeach
                        <thead>
                        <tr>
                            <td class="center-align">Disciplines | Students</td>
                            @foreach($commonStudents as $s)
                                <td class="center-align">
                                    <a href="{{url('/team/'.$team->name.'/mark/student/'.$s['studentId'])}}">
                                        <small>{{$s['student']}}</small>
                                    </a>
                                </td>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                            @for($i=0; $i<count($common);)
                                <tr>
                                    <td><small>{{$common[$i]['discipline']}}</small></td>
                                    @for($j=0; $j<count($commonStudents); $j++)
                                        <td class="center-align">
                                            {{$common[$i]['mark']}}
                                        </td>
                                        <?php $i++; ?>
                                    @endfor
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                <div class="card-action right-align">
                </div>
            </div>
        </div>
    </div>
@endsection
