@auth
    <ul id="slide-out" class="sidenav sidenav-fixed" >
        {{-- Header --}}
        <li><div class="user-view">
                <div class="background indigo darken-2">
                </div>
                <a href="#user"><img class="circle" src="{{asset('/uploads/avatars/'.Auth::user()->avatar)}}"></a>
                <a href="#name"><span class="white-text name">{{Auth::user()->getShortName()}}</span></a>

                <a href="#email"><span class="white-text email">{{Auth::user()->email}}</span></a>
            </div>
        </li>
        <li><a href="{{url('/manage')}}"><i class="material-icons">apps</i>@lang('app.Main')</a></li>
        <li><a href="{{url('/news')}}"><i class="material-icons">new_releases</i>@lang('app.News')</a></li>
        <li>
            <a href="{{url('/notification')}}">
                <i class="material-icons">notifications</i>
                @lang('app.Notifications')
                @if(count(Auth::user()->unreadNotifications) > 0)
                    <span class="badge new red">{{count(Auth::user()->unreadNotifications)}}</span>
                @endif
            </a>
        </li>
        <li><a href="{{url('/conversations')}}"><i class="material-icons">chat</i>@lang('app.Chat')</a></li>
        <li><a href="{{url('/library')}}"><i class="material-icons">library_books</i>@lang('app.Library')</a></li>

        {{-- Administrator --}}
        @include('_includes.nav.roles.administrator')

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
        <li><a class="subheader">@lang('app.Settings')</a></li>
        <li><a href="{{url('/user/settings')}}"><i class="material-icons">settings</i>@lang('app.Settings')</a></li>
        <li><a href="{{url('/user/profile')}}" style="margin-bottom: 5em"><i class="material-icons">assignment_ind</i>@lang('app.Profile')</a></li>
    </ul>
@endauth