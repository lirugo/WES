@auth
    <ul id="slide-out" class="sidenav sidenav-fixed">
        {{-- Header --}}
        <li><div class="user-view">
                <div class="background">
                    <img src="https://www.gettyimages.ca/gi-resources/images/Homepage/Hero/UK/CMS_Creative_164657191_Kingfisher.jpg">
                </div>
                <a href="#user"><img class="circle" src="{{asset('/uploads/avatars/'.Auth::user()->avatar)}}"></a>
                <a href="#name"><span class="white-text name">{{Auth::user()->getShortName()}}</span></a>

                <a href="#email"><span class="white-text email">{{Auth::user()->email}}</span></a>
            </div>
        </li>
        <li><a href="{{url('/manage')}}"><i class="material-icons">apps</i>Main</a></li>
        <li><a href="{{url('/news')}}"><i class="material-icons">new_releases</i>News</a></li>
        <li><a href="#!"><i class="material-icons">notifications</i>Notifications</a></li>
        <li><a href="#!"><i class="material-icons">library_books</i>Library</a></li>

        {{-- Manager --}}
        @if(Auth::user()->hasRole('manager'))
            <li><div class="divider"></div></li>
            <li><a class="subheader">Manager</a></li>
            <li>
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header"><i class="material-icons">school</i>Teachers</div>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="{{url('/teacher/create')}}"><i class="material-icons">person_add</i>Create a new teacher</a></li>
                                <li><a href="{{url('/teacher/')}}"><i class="material-icons">group</i>Show all teachers</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">person</i>Students</div>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="{{url('/student/create')}}"><i class="material-icons">person_add</i>Create a new student</a></li>
                                <li><a href="{{url('/student/')}}"><i class="material-icons">group</i>Show all students</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">group</i>Groups</div>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="{{url('/team/create')}}"><i class="material-icons">group_add</i>Create a new group</a></li>
                                <li><a href="{{url('/team')}}"><i class="material-icons">group</i>Show all groups</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">view_list</i>Disciplines</div>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="{{url('/discipline/create')}}"><i class="material-icons">playlist_add</i>Create a new discipline</a></li>
                                <li><a href="{{url('/discipline')}}"><i class="material-icons">view_list</i>Show all disciplines</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
        {{-- Student --}}
        @elseif(Auth::user()->hasRole('student'))
            <li><div class="divider"></div></li>
            @if(count(Auth::user()->teams()) == 0)
                <li><blockquote>Not have any group yet...</blockquote></li>
            @else
            <li><a class="subheader">Student</a></li>
                <li>
                    <ul class="collapsible">
                        @foreach(Auth::user()->teams() as $team)
                        <li>
                            <div class="collapsible-header"><i class="material-icons">group</i>{{$team->name}}</div>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="{{url('/manage/student/team/'.$team->name)}}"><i class="material-icons">dashboard</i>Dashboard</a></li>
                                    <li><a href="{{url('/manage/student/team/'.$team->name.'/schedule')}}"><i class="material-icons">schedule</i>Schedule</a></li>
                                    <li><a href="#"><i class="material-icons">bookmark_border</i>Marks</a></li>
                                    <li><a href="#"><i class="material-icons">event</i>Events</a></li>
                                    <li><a href="#"><i class="material-icons">group</i>Group</a></li>
                                    <li><a href="#"><i class="material-icons">message</i>Message</a></li>
                                    <li><a href="#"><i class="material-icons">subject</i>Subjects</a></li>
                                    <li><a href="{{url('/manage/student/team/'.$team->name.'/teachers')}}"><i class="material-icons">school</i>Teachers</a></li>
                                    <li><a href="#"><i class="material-icons">home</i>Home Work</a></li>
                                    <li><a href="#"><i class="material-icons">import_contacts</i>Educational Materials</a></li>
                                </ul>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </li>
            @endif
        @elseif(Auth::user()->hasRole('top-manager'))
            <li><div class="divider"></div></li>
            <li><a class="subheader">Top manager</a></li>
            <li>
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header"><i class="material-icons">group</i>Manager</div>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="{{url('/manager/create')}}"><i class="material-icons">group_add</i>Create a new manager</a></li>
                                <li><a href="#"><i class="material-icons">group</i>Show all managers</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
        @endif
        {{-- Settings --}}
        <li><div class="divider"></div></li>
        <li><a class="subheader">Settings</a></li>
        <li><a href="#!"><i class="material-icons">settings</i>Settings</a></li>
        <li><a href="#!"><i class="material-icons">assignment_ind</i>Profile</a></li>
        <li> <a href="{{route('logout')}}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                <i class="material-icons">exit_to_app</i>Logout
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: one;">
                    {{ csrf_field() }}
                </form>
            </a>
        </li>
    </ul>
@endauth