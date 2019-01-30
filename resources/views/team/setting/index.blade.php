@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-show-setting', $team) }}
@endsection
@section('content')
    <div class="row m-t-20" id="team-setting">
        <div class="col s12">
            <ul class="collapsible popout">
                {{--Disciplines--}}
                <li>
                    <div class="collapsible-header"><i class="material-icons">access_time</i>Disciplines</div>
                    <div class="collapsible-body p-t-0 p-b-0">
                        <table>
                            <thead>
                            <tr>
                                <th>Teacher</th>
                                <th>Hours</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Alvin Alvin Alvin</td>
                                <td class="no-padding" style="width:80px;">
                                    <input value="24" id="first_name" type="text" class="validate">
                                </td>
                                <td>
                                    <button class="btn btn-small green waves-effect waves-light right" type="submit" name="action">
                                        <i class="material-icons">save</i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Alvin Alvin Alvin</td>
                                <td class="no-padding" style="width:80px;">
                                    <input value="24" id="first_name" type="text" class="validate">
                                </td>
                                <td>
                                    <button class="btn btn-small green waves-effect waves-light right" type="submit" name="action">
                                        <i class="material-icons">save</i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Alvin Alvin Alvin</td>
                                <td class="no-padding" style="width:80px;">
                                    <input value="24" id="first_name" type="text" class="validate">
                                </td>
                                <td>
                                    <button class="btn btn-small green waves-effect waves-light right" type="submit" name="action">
                                        <i class="material-icons">save</i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Alvin Alvin Alvin</td>
                                <td class="no-padding" style="width:80px;">
                                    <input value="24" id="first_name" type="text" class="validate">
                                </td>
                                <td>
                                    <button class="btn btn-small green waves-effect waves-light right" type="submit" name="action">
                                        <i class="material-icons">save</i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">group</i>Students</div>
                    <div class="collapsible-body"><span>Nothing here yet</span></div>
                </li>
                <li>
                    <div class="collapsible-header"><i class="material-icons">details</i>Other</div>
                    <div class="collapsible-body"><span>Nothing here yet</span></div>
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        new Vue({
            el: '#team-setting',
            mounted(){
                console.log('Team setting mounted')
            }
        })
    </script>
@endsection