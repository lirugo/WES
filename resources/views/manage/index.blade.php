@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('manage') }}
@endsection

@section('content')
    <div class="row" id="manage">
        <div class="col s12">
            <div class="card white">

                @if(Auth::user()->hasRole(['student']))
                <div class="card-content">
                    <div class="input-field col s3">
                        <select v-model="selectedTeam">
                            <option value="" selected>@lang('app.All')</option>
                            <option v-for="team in teams" :value="team.name">@{{team.display_name}}</option>
                        </select>
                        <label>@lang('app.Group')</label>
                    </div>
                    <div class="input-field col s3">
                        <select v-model="selectedType">
                            <option value="" selected>@lang('app.All')</option>
                            <option v-for="type in activityTypes" :value="type.key">@{{type.value}}</option>
                        </select>
                        <label>@lang('app.Type')</label>
                    </div>
                    <div class="input-field col s3">
                        <select v-model="selectedDiscipline">
                            <option value="" selected>@lang('app.All')</option>
                            <option v-for="discipline in disciplines" :value="discipline.name">@{{discipline.display_name}}</option>
                        </select>
                        <label>@lang('app.Subject')</label>
                    </div>

                    <table class="responsive-table highlight">
                        <thead>
                        <tr>
                            <th>@lang('app.Group')</th>
                            <th width="120">@lang('app.Type')</th>
                            <th>@lang('app.Subject')</th>
                            <th>@lang('app.Activity name')</th>
                            <th>@lang('app.Start Date')</th>
                            <th>@lang('app.End Date')</th>
<!--                            <th class="center">@lang('app.Mark in Journal')</th>-->
                            <th class="center">@lang('app.Mark')</th>
                            <th class="center">@lang('app.Max Mark')</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="activity in sortedActivities">
                            <td>@{{activity.team.display_name}}</td>
                            <td>@{{activity.type_full}}</td>
                            <td>@{{activity.discipline.display_name}}</td>
                            <td><a :href="activity.link">@{{activity.name}}</a></td>
                            <td>@{{activity.start_date}}</td>
                            <td>@{{activity.end_date}}</td>
<!--                            <td class="center">@{{activity.mark_in_journal}}</td>-->
                            <td class="center">@{{activity.mark}}</td>
                            <td class="center">@{{activity.max_mark}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @else
                <div class="card-content">
                    <span class="card-title">@lang('app.Manage Panel')</span>
                    <p>
                         @lang('app.No content yet...')
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script>
    new Vue({
        el: '#manage',
        data: {
            selectedTeam: null,
            selectedType: null,
            selectedDiscipline: null,
            user: {!! Auth::user() !!},
            teams: {!! $teams !!},
            activities: {!! $activities !!},
            disciplines: {!! $disciplines !!},
            activityTypes: [],
        },
        created(){
            let activityTypes = {!! json_encode(config('activity')) !!}
            this.activityTypes = Object.entries(activityTypes).map((arr) => ({
                key: arr[0],
                value: arr[1],
            }));
        },
        computed : {
            sortedActivities() {
                return this.activities
                    .filter(a => this.selectedTeam ? this.selectedTeam === a.team.name : true )
                    .filter(a => this.selectedType ? this.selectedType === a.type : true )
                    .filter(a => this.selectedDiscipline ? this.selectedDiscipline === a.discipline.name : true )
                    .sort((a, b) => b.type < a.type ? 1 : -1);
            }
        },
        methods: {
        }
    })
</script>
@endsection
