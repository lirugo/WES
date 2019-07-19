@extends('layouts.welcome')

@section('content')
    <div class="row">
        <div class="col s12 m6 l4 offset-l4 offset-m3">
            <div class="row m-t-100">
                <div class="card hoverable black opacity-80">
                    <div class="card-content white-text">
                        <div class="row m-b-0">
                            {!! Form::open(['route' => 'auth.token', 'method' => 'POST']) !!}
                            <div class="input-field col s12">
                                <input id="key" name="key" type="password" class="validate" required autocomplete="off" readonly
                                       onfocus="this.removeAttribute('readonly');">
                                <label for="key">@lang('app.Enter Your Key From SMS')</label>
                            </div>
                                <button class="btn waves-effect waves-light grey lighten-5 indigo-text right" type="submit" name="action">@lang('app.Check key')
                                    <i class="material-icons right">send</i>
                                </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection