<nav class="indigo">
    <div class="nav-wrapper m-l-20 m-r-20">
        <a href="{{url('')}}" class="brand-logo">{{config('app.name')}}</a>
        @auth
            <ul class="right hide-on-med-and-down">
                <li><a href="badges.html"><i class="material-icons">view_module</i></a></li>
                <li>
                    <a href="{{route('logout')}}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        <i class="material-icons">exit_to_app</i>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: one;">
                            {{ csrf_field() }}
                        </form>
                    </a>
                </li>
            </ul>
        @endguest
    </div>
</nav>