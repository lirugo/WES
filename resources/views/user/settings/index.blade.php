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
                        <div class="collapsible-header"><i class="material-icons">notifications</i>Notifications</div>
                        <div class="collapsible-body p-t-0 p-b-0 p-l-0 p-r-0">
                            <ul class="collection">
                                <li class="collection-item">
                                    <div class="switch">
                                        New mark
                                        <label class="left m-r-10">
                                            SMS
                                            <input type="checkbox" name="sms_new_mark" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->sms_new_mark ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            EMAIL
                                            <input type="checkbox" name="email_new_mark" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->email_new_mark ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        New activity message
                                        <label class="left m-r-10">
                                            SMS
                                            <input type="checkbox" name="sms_new_activity_message" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->sms_new_activity_message ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            EMAIL
                                            <input type="checkbox" name="email_new_activity_message" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->email_new_activity_message ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        New test
                                        <label class="left m-r-10">
                                            SMS
                                            <input type="checkbox" name="sms_new_test" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->sms_new_test ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            EMAIL
                                            <input type="checkbox" name="email_new_test" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->email_new_test ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        New activity
                                        <label class="left m-r-10">
                                            SMS
                                            <input type="checkbox" name="sms_new_activity" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->sms_new_activity ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            EMAIL
                                            <input type="checkbox" name="email_new_activity" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->email_new_activity ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        Update schedule
                                        <label class="left m-r-10">
                                            SMS
                                            <input type="checkbox" name="sms_update_schedule" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->sms_update_schedule ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            EMAIL
                                            <input type="checkbox" name="email_update_schedule" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->email_update_schedule ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        Update activity
                                        <label class="left m-r-10">
                                            SMS
                                            <input type="checkbox" name="sms_update_activity" {{isset(Auth()->user()->settingNotifications) && Auth()->user()->settingNotifications->sms_update_activity ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            EMAIL
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
                        <div class="collapsible-header"><i class="material-icons">language</i>General Settings</div>
                        <div class="collapsible-body p-t-0 p-b-0 p-l-0 p-r-0">
                            <ul class="collection">
                                <li class="collection-item">
                                    <div class="switch">
                                        Default language
                                        <label class="left m-r-10">
                                            <input class="with-gap" name="language" value="en" type="radio" {{Session::get('locale') == 'en' ? 'checked' : ''}} disabled/>
                                            <span>EN</span>
                                        </label>
                                        <label class="left m-r-10">
                                            <input class="with-gap" name="language" value="ua" type="radio" {{Session::get('locale') == 'ua' ? 'checked' : ''}} disabled/>
                                            <span>UA</span>
                                        </label>
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
            <button type="submit" class="btn-floating btn-large green tooltipped pulse" data-position="left" data-tooltip="Save Settings">
                <i class="large material-icons">save</i>
            </button>
        </div>
    </form>
@endsection
