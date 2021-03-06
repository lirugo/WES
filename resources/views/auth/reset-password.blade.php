@extends('layouts.welcome')

@section('content')
    <div class="row valign-wrapper height-100vh m-b-0">
        <div class="col s12 m6 l4 offset-l4 offset-m3">
            <div class="row">
                <div class="card hoverable black opacity-80">
                    <div class="card-content white-text">
                        <div class="row m-b-0">
                            <form method="POST" action="/reset-password/{{request()->token}}?email={{request()->email}}">

                            <input name="_token" type="hidden" value="{{csrf_token()}}">
                            <input name="token" type="hidden" value="{{request()->token}}">
                            <input name="email" type="hidden" value="{{request()->email}}">

                            <span class="card-title center">New password</span>
                            <div class="input-field col s12 m-b-0">
                                <i class="material-icons prefix">vpn_key</i>
                                {!! Form::password('password', null, ['class' => 'validate', 'id' => 'password', 'required', 'autofocus']) !!}
                                {!! Form::label('password', 'Password', ['class' => 'active']) !!}
                                <span class="helper-text" data-error="@lang('app.Password not correct')" data-success="@lang('app.All is OK')"></span>
                            </div>
                            <div class="col s12">
                                <button class="btn waves-effect waves-light grey lighten-5 indigo-text right" type="submit" name="action">
                                    Save
                                    <i class="material-icons right">send</i>
                                </button>
                                <a class="btn waves-effect waves-light grey lighten-5 indigo-text right m-r-5" href="/login">
                                    Go back
                                </a>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection