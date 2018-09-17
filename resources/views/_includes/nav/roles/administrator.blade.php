@if(Auth::user()->hasRole('administrator'))
    <li><div class="divider"></div></li>
    <li><a class="subheader">Administrator</a></li>
    <li>
        <ul class="collapsible">
            <li>
                <div class="collapsible-header"><i class="material-icons">person</i>Top-Manager</div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="{{url('/top-manager/create')}}"><i class="material-icons">person_add</i>Create a new top-manager</a></li>
                        <li><a href="{{url('/top-manager/')}}"><i class="material-icons">group</i>Show all top-managers</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
@endif