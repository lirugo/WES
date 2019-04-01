@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-settings') }}
@endsection

@section('content')
    <form action="{{url('/user/settings')}}" method="POST">
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
                                            <input type="checkbox" name="sms_new_mark" disabled>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            EMAIL
                                            <input type="checkbox" name="email_new_mark" {{Auth()->user()->settingNotifications->email_new_mark ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        New chat message
                                        <label class="left m-r-10">
                                            SMS
                                            <input type="checkbox" name="sms_new_chat_message" disabled>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            EMAIL
                                            <input type="checkbox" name="email_new_chat_message" {{Auth()->user()->settingNotifications->email_new_chat_message ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        New test
                                        <label class="left m-r-10">
                                            SMS
                                            <input type="checkbox" name="sms_new_test" disabled>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            EMAIL
                                            <input type="checkbox" name="email_new_test" {{Auth()->user()->settingNotifications->email_new_test ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        New activity
                                        <label class="left m-r-10">
                                            SMS
                                            <input type="checkbox" name="sms_new_activity" disabled>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            EMAIL
                                            <input type="checkbox" name="email_new_activity" {{Auth()->user()->settingNotifications->email_new_activity ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        Update schedule
                                        <label class="left m-r-10">
                                            SMS
                                            <input type="checkbox" name="sms_update_schedule" disabled>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            EMAIL
                                            <input type="checkbox" name="email_update_schedule" {{Auth()->user()->settingNotifications->email_update_schedule ? 'checked' : ''}}>
                                            <span class="lever"></span>
                                        </label>
                                    </div>
                                </li>
                                <li class="collection-item">
                                    <div class="switch">
                                        Update activity
                                        <label class="left m-r-10">
                                            SMS
                                            <input type="checkbox" name="sms_update_activity" disabled>
                                            <span class="lever"></span>
                                        </label>
                                        <label class="left m-r-10">
                                            EMAIL
                                            <input type="checkbox" name="email_update_activity" {{Auth()->user()->settingNotifications->email_update_activity ? 'checked' : ''}}>
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
                                            <input class="with-gap" name="group1" type="radio" checked />
                                            <span>EN</span>
                                        </label>
                                        <label class="left m-r-10">
                                            <input class="with-gap" name="group1" type="radio"  />
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
