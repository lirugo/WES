@if(Auth::user()->hasRole('top-manager'))
    <li><div class="divider"></div></li>
    <li><a class="subheader">@lang('app.Top manager')</a></li>
    <li>
        <ul class="collapsible">
            <li>
                <div class="collapsible-header"><i class="material-icons">school</i>@lang('app.Teachers')</div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="{{url('/teacher/create')}}"><i class="material-icons">person_add</i>@lang('app.Create a new teacher')</a></li>
                        <li><a href="{{url('/teacher/')}}"><i class="material-icons">group</i>@lang('app.Show all teachers')</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header"><i class="material-icons">person</i>@lang('app.Manager')</div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="{{url('/manager/create')}}"><i class="material-icons">person_add</i>@lang('app.Create a new manager')</a></li>
                        <li><a href="{{url('/manager/')}}"><i class="material-icons">group</i>@lang('app.Show all managers')</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header"><i class="material-icons">view_list</i>@lang('app.Disciplines')</div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="{{url('/discipline/create')}}"><i class="material-icons">playlist_add</i>@lang('app.Create a new discipline')</a></li>
                        <li><a href="{{url('/discipline')}}"><i class="material-icons">view_list</i>@lang('app.Show all disciplines')</a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div class="collapsible-header"><i class="material-icons">group</i>@lang('app.Template for Group')</div>
                <div class="collapsible-body">
                    <ul>
                        <li><a href="{{url('/team/template/create')}}"><i class="material-icons">group_add</i>@lang('app.Create a new Template')</a></li>
                        <li><a href="{{url('/team/template')}}"><i class="material-icons">group</i>@lang('app.Show all Templates')</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
@endif