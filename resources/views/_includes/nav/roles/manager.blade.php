@if(Auth::user()->hasRole('manager'))
    <li><div class="divider"></div></li>
    <li><a class="subheader">@lang('app.Manager')</a></li>
    <li>
        <ul class="collapsible">
            <li>
                <div class="collapsible-header"><i class="material-icons">person</i>@lang('app.Students')</div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="{{url('/student/create')}}"><i class="material-icons">person_add</i>@lang('app.Create a new student')</a></li>
                        <li><a href="{{url('/student/')}}"><i class="material-icons">group</i>@lang('app.Show all students')</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header"><i class="material-icons">group</i>@lang('app.Groups')</div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="{{url('/team/create')}}"><i class="material-icons">group_add</i>@lang('app.Create a new group')</a></li>
                        <li><a href="{{url('/team')}}"><i class="material-icons">group</i>@lang('app.Show all groups')</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
@endif