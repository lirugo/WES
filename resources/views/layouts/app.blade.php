<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App Name -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google reCAPTCHA API -->
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Stylesheets -->
    @yield('style')
</head>
<body>

    <!-- Preloader -->
   @include('_includes.preloader.page')

    <!-- Application -->
    <div id="app">
        <div id="content">
            @include('_includes.nav.top')

            @include('_includes.nav.left')
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <strong> Errors: </strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')

</body>
</html>
