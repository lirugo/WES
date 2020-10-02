@extends('layouts.welcome')

@section('content')
    <div class="row valign-wrapper height-100vh m-b-0">
        <div class="col s12 m6 l4 offset-l4 offset-m3">
            <div class="row">
                <div class="card hoverable black opacity-80">
                    <div class="card-content white-text">
                        <div class="row m-b-0">
                            {!! Form::open(['route' => 'login', 'method' => 'POST']) !!}
                            <span class="card-title center">Sign in</span>
                            <div class="input-field col s12 m-b-0">
                                <i class="material-icons prefix">email</i>
                                {!! Form::email('email', null, ['class' => 'validate', 'id' => 'email', 'required', 'autofocus']) !!}
                                {!! Form::label('email', trans('app.Enter Your Email'), ['class' => 'active']) !!}
                                <span class="helper-text" data-error="@lang('app.Email not correct')" data-success="@lang('app.All is OK')"></span>
                            </div>
                            <div class="input-field col s12 m-b-0">
                                <i class="material-icons prefix">vpn_key</i>
                                {!! Form::password('password', ['id' => 'password', 'required']) !!}
                                {!! Form::label('password', trans('app.Enter Your Password')) !!}
                                <span class="helper-text" data-error="@lang('app.Minimum 6 chars at least 1 number and 1 capital letter')" data-success="@lang('app.All is OK')"></span>
                            </div>
                            {{--<div class="input-field col s12 m-b-30">--}}
                                {{--<div class="g-recaptcha right" data-sitekey="{{env('GOOGLE_CAPTCHA_KEY')}}"></div>--}}
                            {{--</div>--}}
                            <div class="col s12">
                                <button class="btn waves-effect waves-light grey lighten-5 indigo-text right" type="submit" name="action">@lang('app.Sign in')
                                    <i class="material-icons right">send</i>
                                </button>
                                <a class="btn waves-effect waves-light grey lighten-5 indigo-text right m-r-5" href="/reset-password">
                                    Forgot password?
                                </a>
                                {{--<label>--}}
                                    {{--<input type="checkbox" />--}}
                                    {{--<span>Remember Me?</span>--}}
                                {{--</label>--}}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection