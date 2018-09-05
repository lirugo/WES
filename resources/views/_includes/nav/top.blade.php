<nav class="indigo darken-2">
    <div class="nav-wrapper m-l-20 m-r-20">
        <a href="{{url('')}}" class="brand-logo">{{config('app.name')}}</a>
        <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        @auth
            <ul class="right hide-on-med-and-down">
                <li><a href="#"><i class="material-icons">notifications</i></a></li>
                <li><a href="{{route('logout')}}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        <i class="material-icons">exit_to_app</i>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </a>
                </li>
            </ul>
        @endguest
    </div>
</nav>