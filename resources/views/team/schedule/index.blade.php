@extends('layouts.app')
@section('breadcrumbs')
    {{ Breadcrumbs::render('team-show-schedule', $team) }}
@endsection
@section('style')
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <style>
        .my-event {
            overflow: hidden;
            border-radius: 2px;
            background-color: #3F51B5;
            color: #ffffff;
            border: 1px solid #1867c0;
            width: 100%;
            font-size: 12px;
            padding: 3px;
            cursor: pointer;
            margin-bottom: 1px;
        }
        .my-event.with-time {
            position: absolute;
            margin-right: 0px;
        }
        .v-for-item + .v-for-item:before {
            content: ", ";
        }
    </style>
@endsection
@section('content')
    {{--Calendar--}}
    <div id="calendar">
        <v-app class="grey lighten-3">
            <v-container fluid class="pa-2">
                <v-layout>
                    <v-flex
                            sm12
                    >
                        <v-card class="hoverable">
                            {{--Actions--}}
                            <v-layout wrap>
                                <v-flex
                                        sm4
                                        xs12
                                        class="text-sm-left text-xs-center mt-3"
                                >
                                    <v-btn @click="$refs.calendar.prev()" class="grey lighten-3">
                                        <v-icon
                                                dark
                                        >
                                            keyboard_arrow_left
                                        </v-icon>
                                    </v-btn>
                                    <v-btn @click="$refs.calendar.next()" class="grey lighten-3">
                                        <v-icon
                                                dark
                                        >
                                            keyboard_arrow_right
                                        </v-icon>
                                    </v-btn>
                                </v-flex>
                                <v-flex
                                        sm4
                                        xs12
                                >
                                    <v-select
                                            v-model="type"
                                            :items="typeOptions"
                                    ></v-select>
                                </v-flex>
                            </v-layout>

                            {{--Calendar--}}
                            <v-sheet height="650">
                                <v-calendar
                                        ref="calendar"
                                        v-model="start"
                                        :type="type"
                                        color="primary"
                                        :weekdays="[1, 2, 3, 4, 5, 6, 0]"
                                        :short-weekdays="false"
                                        :short-months="false"
                                >
                                    {{--Mounth--}}
                                    <template
                                            slot="day"
                                            slot-scope="{ date }"
                                    >
                                        <template v-for="event in eventsMap[date]">
                                            <v-menu
                                                    :key="event.id"
                                                    v-model="event.open"
                                                    full-width
                                                    offset-x
                                            >
                                                <div
                                                        slot="activator"
                                                        v-ripple
                                                        class="my-event"
                                                        v-html="event.title"
                                                ></div>
                                                <v-card
                                                        color="grey lighten-4"
                                                        min-width="350px"
                                                        flat
                                                >
                                                    <v-toolbar
                                                            color="indigo lighten-1"
                                                            dark
                                                    >
                                                        <v-toolbar-title v-html="event.title"></v-toolbar-title>
                                                    </v-toolbar>
                                                    @if(Auth::user()->hasRole(['administrator', 'top-manager', 'manager', 'teacher']))
                                                        <v-card-title primary-title class="pa-2" v-if="event.tools.length != 0">
                                                            <span v-for="(tool, index) in event.tools" :key="tool.id" class="v-for-item">
                                                                @{{tool}}
                                                            </span>
                                                        </v-card-title>
                                                    @endif
                                                    <v-card-title class="pa-1">
                                                        <v-icon class="mr-2">
                                                            access_time
                                                        </v-icon>
                                                        <span class="grey--text">
                                                            @{{ event.start_time }} - @{{  event.end_time }},
                                                            @{{ event.duration }} min
                                                        </span>
                                                    </v-card-title>
                                                </v-card>
                                            </v-menu>
                                        </template>
                                    </template>
                                    {{--Week--}}
                                    <template
                                            slot="dayBody"
                                            slot-scope="{ date, timeToY, minutesToPixels }"
                                    >
                                        <template v-for="event in eventsMap[date]">
                                            <!-- timed events -->
                                            <div
                                                    :key="event.id"
                                                    :style="{ top: timeToY(event.start_time) + 'px', height: minutesToPixels(event.duration) + 'px' }"
                                                    class="my-event with-time"
                                            >
                                                <strong>@{{event.title}}</strong>
                                            </div>
                                        </template>
                                    </template>
                                </v-calendar>
                            </v-sheet>
                        </v-card>
                    </v-flex>
                </v-layout>
                {{--Table--}}
                @if(Auth::user()->hasRole(['administrator', 'top-manager', 'manager', 'teacher']))
                    <div class="">
                        <div class="col s12">
                            <div class="card hoverable">
                                <div class="card-content">
                                    <table class="striped">
                                        <thead>
                                        <tr>
                                            <th>@lang('app.Title')(</th>
                                            <th>@lang('app.Start Date')</th>
                                            <th>@lang('app.End Date')</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(Auth::user()->hasRole('teacher'))
                                            @foreach($team->getTeacherSchedules() as $schedule)
                                                <tr>
                                                    <td>{{$schedule->title}}</td>
                                                    <td>{{$schedule->start_date}}</td>
                                                    <td>{{$schedule->end_date}}</td>
                                                    <td>
                                                        {{--If start date - date now more than 14 day teacher can delete lecture--}}
                                                        @if(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($schedule->start_date), false) > 14)
                                                            {!! Form::open(['route' => ['team.schedule.delete', $team->name, $schedule->id]]) !!}
                                                            <button type="submit" class="waves-effect waves-light btn red"><i class="material-icons">delete</i></button>
                                                            {!! Form::close() !!}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach($team->schedules as $schedule)
                                                <tr>
                                                    <td style="max-width: 500px;">{{$schedule->title}}</td>
                                                    <td>{{$schedule->start_date}}</td>
                                                    <td>{{$schedule->end_date}}</td>
                                                    <td>
                                                        {!! Form::open(['route' => ['team.schedule.delete', $team->name, $schedule->id]]) !!}
                                                        <button type="submit" class="waves-effect waves-light btn red"><i class="material-icons">delete</i></button>
                                                        {!! Form::close() !!}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--Floating button--}}
                    <div class="fixed-action-btn">
                        <a class="btn-floating btn-large red" href="{{url('/team/'.$team->name.'/schedule/create')}}">
                            <i class="large material-icons">add</i>
                        </a>
                        <ul>
                            <li><a class="btn-floating orange tooltipped" data-position="left" data-tooltip="PDF" href="{{url('/team/'.$team->name.'/schedule/pdf')}}"><i class="material-icons">cloud_download</i></a></li>
                        </ul>
                    </div>
                @endif
            </v-container>
        </v-app>
    </div>


@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script>
        new Vue({
            el: '#calendar',
            data: {
                type: 'month',
                start: moment().format("YYYY-MM-DD"),
                typeOptions: [
                    { text: 'Week', value: 'week' },
                    { text: 'Month', value: 'month' },
                ],
                events: {!! json_encode($events) !!},
            },
            computed: {
                // convert the list of events into a map of lists keyed by date
                eventsMap () {
                    const map = {}
                    this.events.forEach(e => (map[e.date] = map[e.date] || []).push(e))
                    return map
                }
            },
            methods: {
            }
        })
    </script>
@endsection