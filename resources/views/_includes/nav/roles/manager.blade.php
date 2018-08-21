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
        </ul>
    </li>
@endif