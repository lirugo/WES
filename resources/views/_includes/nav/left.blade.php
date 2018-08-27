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
        <li><a href="{{url('/library')}}"><i class="material-icons">library_books</i>Library</a></li>

        {{-- Top-Manager --}}
        @include('_includes.nav.roles.top-manager')

        {{-- Manager --}}
        @include('_includes.nav.roles.manager')

        {{-- Teacher --}}
        @include('_includes.nav.roles.teacher')

        {{-- Student --}}
        @include('_includes.nav.roles.student')

        {{-- Settings --}}
        <li><div class="divider"></div></li>
        <li><a class="subheader">Settings</a></li>
        <li><a href="#!"><i class="material-icons">settings</i>Settings</a></li>
        <li><a href="{{url('/user/profile')}}"><i class="material-icons">assignment_ind</i>Profile</a></li>
        <li> <a href="{{route('logout')}}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                <i class="material-icons">exit_to_app</i>Logout
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </a>
        </li>
    </ul>
@endauth