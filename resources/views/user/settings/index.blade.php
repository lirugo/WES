@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-settings') }}
@endsection

@section('content')
    <form action="{{url('/user/settings')}}" method="POST">
        {{ csrf_field() }}
        <div class="row m-t-20">
            <div class="col s12 md6">
                <ul class="collapsible popout">
                    {{--                    Notifications--}}
                    <li class="active">
                        <div class="collapsible-header"><i class="material-icons">notifications</i>@lang('app.Notifications')</div>
                        <div class="collapsible-body p-t-0 p-b-0 p-l-0 p-r-0">
                            <ul class="collection">
                                <li class="collection-item">
                                    <div class="switch">
                                        @lang('app.New mark')
                                        <label class="left m-r-10">
                                            @lang('app.SMS')
                                            <input type="checkbox" name="sms_new_mark" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->sms_new_mark ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            @lang('app.EMAIL')
                                            <input type="checkbox" name="email_new_mark" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->email_new_mark ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        @lang('app.New group work')
                                        <label class="left m-r-10">
                                            @lang('app.SMS')
                                            <input type="checkbox" name="sms_new_group_work" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->sms_new_group_work ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            @lang('app.EMAIL')
                                            <input type="checkbox" name="email_new_group_work" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->email_new_group_work ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        @lang('app.New activity message')
                                        <label class="left m-r-10">
                                            @lang('app.SMS')
                                            <input type="checkbox" name="sms_new_activity_message" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->sms_new_activity_message ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            @lang('app.EMAIL')
                                            <input type="checkbox" name="email_new_activity_message" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->email_new_activity_message ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        @lang('app.New test')
                                        <label class="left m-r-10">
                                            @lang('app.SMS')
                                            <input type="checkbox" name="sms_new_test" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->sms_new_test ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            @lang('app.EMAIL')
                                            <input type="checkbox" name="email_new_test" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->email_new_test ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        @lang('app.New activity')
                                        <label class="left m-r-10">
                                            @lang('app.SMS')
                                            <input type="checkbox" name="sms_new_activity" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->sms_new_activity ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            @lang('app.EMAIL')
                                            <input type="checkbox" name="email_new_activity" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->email_new_activity ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        @lang('app.Update schedule')
                                        <label class="left m-r-10">
                                            @lang('app.SMS')
                                            <input type="checkbox" name="sms_update_schedule" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->sms_update_schedule ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            @lang('app.EMAIL')
                                            <input type="checkbox" name="email_update_schedule" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->email_update_schedule ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        @lang('app.Update activity')
                                        <label class="left m-r-10">
                                            @lang('app.SMS')
                                            <input type="checkbox" name="sms_update_activity" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->sms_update_activity ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            @lang('app.EMAIL')
                                            <input type="checkbox" name="email_update_activity" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->email_update_activity ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    {{--                    General settings--}}
                    <li>
                        <div class="collapsible-header"><i class="material-icons">language</i>@lang('app.General Settings')</div>
                        <div class="collapsible-body p-t-0 p-b-0 p-l-0 p-r-0">
                            <ul class="collection">
                                <li class="collection-item">
                                    <div class="switch">
                                        @lang('app.Default language')
                                        <label class="left m-r-10">
                                            <input class="with-gap" name="language" value="en" type="radio" {{Session::get('locale') == 'en' ? 'checked' : ''}}/>
                                            <span>EN</span>
                                        </label>
                                        <label class="left m-r-10">
                                            <input class="with-gap" name="language" value="ua" type="radio" {{Session::get('locale') == 'ua' ? 'checked' : ''}}/>
                                            <span>UA</span>
                                        </label>
<!--                                        <label class="left m-r-10">-->
<!--                                            <input class="with-gap" name="language" value="ru" type="radio" {{Session::get('locale') == 'ru' ? 'checked' : ''}}/>-->
<!--                                            <span>RU</span>-->
<!--                                        </label>-->
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        {{--Floating button--}}
        <div class="fixed-action-btn">
            <button type="submit" class="btn-floating btn-large green tooltipped pulse" data-position="left" data-tooltip="@lang('app.Save Settings')">
                <i class="large material-icons">save</i>
            </button>
        </div>
    </form>
@endsection
