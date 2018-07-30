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
        <li><a href="#!"><i class="material-icons">new_releases</i>News</a></li>
        <li><a href="#!"><i class="material-icons">notifications</i>Notifications</a></li>
        <li><a href="#!"><i class="material-icons">library_books</i>Library</a></li>

        {{-- Manager --}}
        @if(Auth::user()->hasRole('manager'))
            <li><div class="divider"></div></li>
            <li><a class="subheader">Manager</a></li>
            <li>
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header"><i class="material-icons">person</i>Students</div>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="{{url('/student/create')}}"><i class="material-icons">person_add</i>Create a new student</a></li>
                                <li><a href="#!"><i class="material-icons">group</i>Show all students</a></li>
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
                </ul>
            </li>
        {{-- Student --}}
        @elseif(Auth::user()->hasRole('student'))
            <li><div class="divider"></div></li>
            <li><a class="subheader">Groups</a></li>
            <li>
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header"><i class="material-icons">group</i>GMBA 02</div>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!"><i class="material-icons">group</i>one</a></li>
                                <li><a href="#!">two</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">group</i>EMBA 02</div>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!">one</a></li>
                                <li><a href="#!">two</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="material-icons">group</i>UMBA 02</div>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!">one</a></li>
                                <li><a href="#!">two</a></li>
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
        <li><a href="#!"><i class="material-icons">exit_to_app</i>Logout</a></li>
    </ul>

    @section('scripts')
        <script>

        </script>
    @endsection
@endauth