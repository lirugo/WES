@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-show-setting', $team) }}
@endsection
@section('content')
    <div id="team-setting">
        <div class="progress red" style="margin-top: -4px;" v-if="loading">
            <div class="indeterminate orange"></div>
        </div>

        <div class="row m-t-20"  xmlns:v-bind="http://www.w3.org/1999/xhtml">
            <div class="col s12">
                <ul class="collapsible popout">
                    {{--Disciplines--}}
                    <li class="active">
                        <div class="collapsible-header"><i class="material-icons">access_time</i>@lang('app.Disciplines')</div>
                        <div class="collapsible-body p-t-0 p-b-0">
                            <div class="row">
                                <table class="m-b-10 highlight">
                                    <thead>
                                    <tr>
                                        <th>@lang('app.Disciplines')</th>
                                        <th>@lang('app.Hours')</th>
                                        <th>@lang('app.Active')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="disc in teamDisciplines">
                                        <td>
                                            @{{ disc.get_teacher.name.second_name + ' ' + disc.get_teacher.name.name + ' ' + (disc.get_teacher.name.middle_name ? disc.get_teacher.name.middle_name : '') }}
                                            -
                                            @{{ disc.get_discipline.display_name }}
                                        </td>
                                        <td class="no-padding" style="width:50px;">
                                            <input v-model="disc.hours" type="number" class="validate">
                                        </td>
                                        <td>
                                            <div class="switch">
                                                <label>
                                                    <input type="checkbox"
                                                           v-model="disc.disabled" :true-value="0" :false-value="1">
                                                    <span class="lever"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <button class="btn btn-small green waves-effect waves-light right" @click="disciplineUpdate">
                                    <i class="material-icons">save</i>
                                </button>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">group</i>@lang('app.Students')</div>
                        <div class="collapsible-body"><span>@lang('app.Nothing here yet')</span></div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">details</i>@lang('app.Others')</div>
                        <div class="collapsible-body"><span>@lang('app.Nothing here yet')</span></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        new Vue({
            el: '#team-setting',
            mounted(){
                console.log('Team setting mounted')
            },
            data: {
                loading: false,
                teamDisciplines: {!! $team->disciplines !!}
            },
            methods: {
                disciplineUpdate(){
                    this.loading = true
                    axios.post('/team/{!! $team->name !!}/setting/disciplines/update', this.teamDisciplines)
                        .then(data => data.data)
                        .then(res => {
                            this.teamDisciplines = res
                        })
                        .catch(err => console.log(err))
                        .finally(() => {
                            M.toast({html: 'Successfully updated!', classes: 'green'})
                            this.loading = false
                        })
                }
            }
        })
    </script>
@endsection