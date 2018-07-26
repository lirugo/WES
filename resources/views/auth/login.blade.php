@extends('layouts.welcome')

@section('content')
    <div class="row m-t-100">
        <div class="col s4 offset-s4">
            <div class="row">
                <div class="card hoverable indigo">
                    <div class="card-content white-text">
                        <div class="row m-b-0">
                            {!! Form::open(['route' => 'login', 'method' => 'POST']) !!}
                            <span class="card-title center">Sign in</span>
                            <div class="input-field col s12 m-b-0">
                                <i class="material-icons prefix">email</i>
                                {!! Form::email('email', null, ['class' => 'validate', 'id' => 'email', 'required', 'autofocus']) !!}
                                {!! Form::label('email', 'Enter Your Email', ['class' => 'active']) !!}
                                <span class="helper-text" data-error="Email not correct" data-success="All is OK"></span>
                            </div>
                            <div class="input-field col s12 m-b-0">
                                <i class="material-icons prefix">vpn_key</i>
                                {!! Form::password('password', ['id' => 'password', 'required']) !!}
                                {!! Form::label('password', 'Enter Your Password') !!}
                                <span class="helper-text" data-error="Minimum 6 chars at least 1 number and 1 capital letter" data-success="All is OK"></span>
                            </div>
                            <div class="input-field col s12 m-b-30">
                                <div class="g-recaptcha right" data-sitekey="6Lc_w2UUAAAAABDMaDvisV-3Wg1IT09Kgr0qg4fW"></div>
                            </div>
                            <div class="col s12">
                                <label>
                                    <input type="checkbox" />
                                    <span>Remember Me?</span>
                                </label>
                                <button class="btn waves-effect waves-light grey lighten-5 indigo-text right" type="submit" name="action">Sign in
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection