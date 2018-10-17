@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-mark-discipline', $team, $discipline) }}
@endsection
@section('content')
    <div class="row">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <table class="highlight striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Task #</th>
                            <th>Task #</th>
                            <th>Task #</th>
                            <th>Total</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td>Alvin</td>
                            <td>Eclair</td>
                            <td>Eclair</td>
                            <td>Eclair</td>
                            <td>$0.87</td>
                        </tr>
                        <tr>
                            <td>Alan</td>
                            <td>Jellybean</td>
                            <td>Jellybean</td>
                            <td>Jellybean</td>
                            <td>$3.76</td>
                        </tr>
                        <tr>
                            <td>Jonathan</td>
                            <td>Lollipop</td>
                            <td>Lollipop</td>
                            <td>Lollipop</td>
                            <td>$7.00</td>
                        </tr>
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
