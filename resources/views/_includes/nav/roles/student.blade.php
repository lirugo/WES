@if(Auth::user()->hasRole('student'))
    <li><div class="divider"></div></li>
    @if(count(Auth::user()->teams()) == 0)
        <li><blockquote>Not have any group yet...</blockquote></li>
    @else
        <li><a class="subheader">Student</a></li>
        <li>
            <ul class="collapsible">
                @foreach(Auth::user()->teams() as $team)
                    <li>
                        <div class="collapsible-header"><i class="material-icons">group</i>{{$team->display_name}}</div>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="{{url('/team/'.$team->name)}}"><i class="material-icons">dashboard</i>Dashboard</a></li>
                                <li><a href="{{url('/team/'.$team->name.'/schedule')}}"><i class="material-icons">schedule</i>Schedule</a></li>
                                {{--<li><a href="#"><i class="material-icons">bookmark_border</i>Marks</a></li>--}}
                                {{--<li><a href="#"><i class="material-icons">event</i>Events</a></li>--}}
                                <li><a href="{{url('/team/'.$team->name.'/students')}}"><i class="material-icons">group</i>Students</a></li>
                                {{--<li><a href="#"><i class="material-icons">message</i>Message</a></li>--}}
                                {{--<li><a href="#"><i class="material-icons">subject</i>Subjects</a></li>--}}
                                <li><a href="{{url('/team/'.$team->name.'/teachers')}}"><i class="material-icons">school</i>Teachers</a></li>
                                <li><a href="{{url('/team/'.$team->name.'/homework')}}"><i class="material-icons">home</i>Home Work</a></li>
                                {{--<li><a href="#"><i class="material-icons">import_contacts</i>Educational Materials</a></li>--}}
                            </ul>
                        </div>
                    </li>
                @endforeach
            </ul>
        </li>
    @endif
@endif