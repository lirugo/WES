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

            @yield('breadcrumbs')

            <div class="main-content">
                @yield('content')
            </div>

            @include('_includes.footer.index')

            @include('_includes.feedback.feedback')
        </div>
    </div>

    <!-- Default Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    {{--Feedback modal--}}
    <script>
        var elem = document.querySelector('.feedback-modal');
        var instance = M.Modal.init(this.elem);

        new Vue({
            el: '#feedback-modal',
            data: {
                instance: null,
            },
            created() {
                this.instance = instance
            },
            methods: {
                showPasswordReset(){
                    this.instance.open();
                },
                save(){

                }
            }
        })
    </script>
    <!-- Toasts -->
    @include('_includes.notification.message')
    <!-- Scripts From Blade -->
    @yield('scripts')

</body>
</html>
