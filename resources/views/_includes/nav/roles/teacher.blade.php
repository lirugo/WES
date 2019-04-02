@if(Auth::user()->hasRole('teacher'))
    <li><div class="divider"></div></li>
    @if(count(Auth::user()->teams()) == 0)
        <li><blockquote>@lang('app.Not have any group yet...')</blockquote></li>
    @else
        <li><a class="subheader">@lang('app.Teacher')</a></li>
        <li>
            <ul class="collapsible">
                @foreach(Auth::user()->teams() as $team)
                    <li class="{{$team->name == Request::segment(2) ? 'active' : ''}}">
                        <div class="collapsible-header"><i class="material-icons">group</i>{{$team->display_name}}</div>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="{{url('/team/'.$team->name)}}"><i class="material-icons">dashboard</i>@lang('app.Dashboard')</a></li>
                                <li><a href="{{url('/team/'.$team->name.'/schedule')}}"><i class="material-icons">schedule</i>@lang('app.Schedule')</a></li>
                                <li><a href="{{url('/team/'.$team->name.'/mark')}}"><i class="material-icons">bookmark_border</i>@lang('app.Marks')</a></li>
                                {{--<li><a href="#"><i class="material-icons">event</i>Events</a></li>--}}
                                <li><a href="{{url('/team/'.$team->name.'/students')}}"><i class="material-icons">group</i>@lang('app.Students')</a></li>
                                {{--<li><a href="#"><i class="material-icons">message</i>Message</a></li>--}}
                                {{--<li><a href="#"><i class="material-icons">subject</i>Subjects</a></li>--}}
                                <li><a href="{{url('/team/'.$team->name.'/teachers')}}"><i class="material-icons">school</i>@lang('app.Teachers')</a></li>
                                <li><a href="{{url('/team/'.$team->name.'/material')}}"><i class="material-icons">import_contacts</i>@lang('app.Educational Materials')</a></li>
                                <li><a href="{{url('/team/'.$team->name.'/activity')}}"><i class="material-icons">home</i>@lang('app.Activity')</a></li>
                                <li><a href="{{url('/team/'.$team->name.'/group-work')}}"><i class="material-icons">group</i>@lang('app.Group Work')</a></li>
                                <li><a href="{{url('/team/'.$team->name.'/pretest')}}"><i class="material-icons">border_color</i>@lang('app.Tests')</a></li>
                            </ul>
                        </div>
                    </li>
                @endforeach
            </ul>
        </li>
    @endif
@endif