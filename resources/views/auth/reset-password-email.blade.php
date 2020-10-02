@extends('layouts.welcome')

@section('content')
    <div class="row valign-wrapper height-100vh m-b-0">
        <div class="col s12 m6 l4 offset-l4 offset-m3">
            <div class="row">
                <div class="card hoverable black opacity-80">
                    <div class="card-content white-text">
                        <div class="row m-b-0">
                            {!! Form::open(['url' => '/reset-password', 'method' => 'POST']) !!}
                            <span class="card-title center">Reset password form</span>
                            <div class="input-field col s12 m-b-0">
                                <i class="material-icons prefix">email</i>
                                {!! Form::email('email', null, ['class' => 'validate', 'id' => 'email', 'required', 'autofocus']) !!}
                                {!! Form::label('email', trans('app.Enter Your Email'), ['class' => 'active']) !!}
                                <span class="helper-text" data-error="@lang('app.Email not correct')" data-success="@lang('app.All is OK')"></span>
                            </div>
                            <div class="col s12">
                                <button class="btn waves-effect waves-light grey lighten-5 indigo-text right" type="submit" name="action">
                                    Reset
                                    <i class="material-icons right">send</i>
                                </button>
                                <a class="btn waves-effect waves-light grey lighten-5 indigo-text right m-r-5" href="/login">
                                    Go back
                                </a>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection