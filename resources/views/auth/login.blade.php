@extends('layouts.welcome')

@section('content')
    <img src="{{url('/images/logo.png')}}" width="250px" alt="IIB">
    {!! Form::open(['route' => 'login', 'method' => 'POST']) !!}
        {!! Form::email('email', null, ['class' => 'validate', 'id' => 'email', 'required', 'autofocus', 'placeholder' => 'Email']) !!}
        {!! Form::password('password', ['id' => 'password', 'required', 'placeholder' => 'Password']) !!}
        <button class="btn waves-effect waves-light grey lighten-5 indigo-text right" type="submit" name="action">@lang('app.Sign in')</button>
    {!! Form::close() !!}
    <a class="small-text" href="/reset-password">
        Forgot password?
    </a>
@endsection