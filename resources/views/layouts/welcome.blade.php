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

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Source Sans Pro', sans-serif;
        }
        body {
            font-family: 'Source Sans Pro', sans-serif;
            color: white;
        }
        body ::-webkit-input-placeholder {
            font-family: 'Source Sans Pro', sans-serif;
            color: white;
        }
        body :-moz-placeholder {
            font-family: 'Source Sans Pro', sans-serif;
            color: white;
            opacity: 1;
        }
        body ::-moz-placeholder {
            font-family: 'Source Sans Pro', sans-serif;
            color: white;
            opacity: 1;
        }
        body :-ms-input-placeholder {
            font-family: 'Source Sans Pro', sans-serif;
            color: white;
        }

        a {
            text-decoration: none;
            color: #63b0d9;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .container {
            max-width: 250px;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        form {
            padding: 10px 0 20px 0;
            position: relative;
            z-index: 2;
        }
        form input {
            display: block;
            appearance: none;
            outline: 0;
            border: 1px solid rgba(255,255,255,0.4);
            background-color: rgba(27,57,100,0.4);
            width: 250px;
            height: 44px;
            border-radius: 3px;
            padding: 10px 15px;
            margin: 0 auto 10px auto;
            text-align: center;
            color: #1c3664;
            transition-duration: 0.25s;
        }
        form input:hover {
            background-color: rgba(27,57,100,0.4);
        }
        form input:focus {
            background-color: rgba(43,136,217,0.9);
            color: #63b0d9;
        }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active{
            -webkit-background-clip: text;
            -webkit-text-fill-color: #ffffff;
            transition: background-color: rgba(27,57,100,0.4) 5000s ease-in-out 0s;
            box-shadow: inset 0 0 20px 20px rgba(27,57,100,0.4);
        }
        form button {
            appearance: none;
            outline: 0;
            background-color: rgba(27,57,100,0.4);
            border: 0;
            padding: 10px 15px;
            color: #1c3664;
            border-radius: 3px;
            width: 250px;
            height: 44px;
            cursor: pointer;
            transition-duration: 0.25s;
        }
        form button:hover {
            background-color: rgba(43,136,217,0.9);
        }

        /* ---- particles.js container ---- */
        #particles-js {
            position: absolute;
            width: 100%;
            height: 99.6%;
            background-color: #f8f8f8;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 50% 50%;
        }

        .normal-btn .btn-text {
            float: left;
            margin: 11px 14px 11px 14px;
            color: #1c3664;
            font-size: 18px;
            letter-spacing: .2px;
            user-select: none
        }
        * {
            color: #fff !important;
        }

        .small-text {
            font-size: .8rem;
            color: #1c3664 !important;
        }


        .reset-password-label {
            font-size: 1rem;
            margin-bottom: 1em !important;
            color: #1c3664 !important;
        }

    </style>

    <!-- Stylesheets -->
    @yield('style')
</head>
<body>

    <!-- Preloader -->
   @include('_includes.preloader.page')


    <!-- Application -->
    <div id="particles-js">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/particles.js') }}"></script>

    <script>

        /* ---- particles.js config ---- */
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 180,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": ["#00b0f5"]
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#00b0f5"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg",
                        "width": 100,
                        "height": 100
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#00438d",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "grab"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 140,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });

    </script>
    @yield('scripts')

    <!-- Toasts -->
    @include('_includes.notification.message')

</body>
</html>
