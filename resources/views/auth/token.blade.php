@extends('layouts.welcome')

@section('content')
    <div class="row m-t-100">
        <div class="col s12 m6 l4 offset-l4 offset-m3">
            <div class="row">
                <div class="card hoverable indigo">
                    <div class="card-content white-text">
                        <div class="row m-b-0">
                            {!! Form::open(['route' => 'auth.token', 'method' => 'POST']) !!}
                            <div class="input-field col s12">
                                <input id="key" name="key" type="password" class="validate">
                                <label for="key">Enter Your Key From SMS</label>
                            </div>
                                <button class="btn waves-effect waves-light grey lighten-5 indigo-text right" type="submit" name="action">Check key
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