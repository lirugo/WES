@extends('layouts.welcome')

@section('content')
    {!! Form::open(['url' => '/reset-password', 'method' => 'POST']) !!}
    <div class="input-field col s12 m-b-0">
        <div class="reset-password-label">Reset password form</div>
        {!! Form::email('email', null, ['class' => 'validate', 'id' => 'email', 'required', 'autofocus', 'placeholder' => 'Email']) !!}
        <span class="helper-text" data-error="@lang('app.Email not correct')" data-success="@lang('app.All is OK')"></span>
    </div>
    <button class="" type="submit" name="action">Reset</button>
    {!! Form::close() !!}
    <a class="small-text" style="padding: 2em;" href="/login">
        Go back
    </a>
@endsection