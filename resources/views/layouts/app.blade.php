<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MedLink') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- SilverBoxAlert -->
    <link href="{{ asset('silverBox.min/silverBox.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('silverBox.min/silverBox.min.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"
        integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #wrapper {
            padding-left: 0;
            transition: all 0.5s ease;

        }

        #sidebar-wrapper {
            z-index: 1000;
            position: fixed;
            left: 250px;
            width: 0;
            height: 100%;
            margin-left: -250px;
            overflow-y: auto;
            overflow-x: hidden;
            background: #222;
            transition: all 0.5s ease;
        }

        #wrapper.toggled #sidebar-wrapper {
            width: 250px;
        }

        .sidebar-brand {
            position: absolute;
            top: 0;
            /*width: 250px;*/
            text-align: center;
            padding: 20px 0;
        }

        .sidebar-brand h2 {
            margin: 0;
            font-weight: 600;
            font-size: 24px;
            color: #fff;
        }

        .sidebar-nav {
            position: absolute;
            /*top: 5px;*/
            width: 250px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .sidebar-nav>li {
            text-indent: 3px;
            line-height: 60px;
        }

        .sidebar-nav>li a {
            display: block;
            text-decoration: none;
            /* color: black; */
            color: linear-gradient(310deg, #7505ff 0%, #44b9fe 100%);
            font-weight: 600;
            font-size: 15px;
        }

        .sidebar-nav>li>a:hover,
        .sidebar-nav>li.active>a {
            text-decoration: none;
            color: black;
            background: white;
        }

        .sidebar-nav>li>a i.fa {
            font-size: 24px;
            width: 33px;
        }

        #navbar-wrapper {
            width: 100%;
            position: absolute;
            z-index: 2;
        }

        #wrapper.toggled #navbar-wrapper {
            position: absolute;
            margin-right: -250px;
        }

        #navbar-wrapper .navbar {
            border-width: 0 0 0 0;
            background-color: #fff;
            font-size: 24px;
            margin-bottom: 0;
            border-radius: 0;
        }

        #navbar-wrapper .navbar a {
            color: black;
        }

        #navbar-wrapper .navbar a:hover {
            color: black;
        }

        #content-wrapper {
            width: 100%;
            position: absolute;
            padding: 15px;
            top: 100px;
        }

        #wrapper.toggled #content-wrapper {
            position: absolute;
            margin-right: -250px;
        }

        #togglebutton {
            display: none;
        }

        @media (min-width: 992px) {
            #wrapper {
                padding-left: 140px;
            }

            #wrapper.toggled {
                padding-left: 60px;
            }

            #sidebar-wrapper {
                width: 170px;
                padding: 50px;
            }

            #wrapper.toggled #sidebar-wrapper {
                width: 60px;
            }

            #wrapper.toggled #navbar-wrapper {
                position: absolute;
                margin-right: -190px;
            }

            #wrapper.toggled #content-wrapper {
                position: absolute;
                margin-right: -190px;
            }

            #navbar-wrapper {
                position: relative;
            }

            #wrapper.toggled {
                padding-left: 60px;
            }

            #content-wrapper {
                position: relative;
                top: 0;
            }

            #wrapper.toggled #navbar-wrapper,
            #wrapper.toggled #content-wrapper {
                position: relative;
                margin-right: 60px;
            }
        }

        @media (min-width: 768px) and (max-width: 1100px) {
            #wrapper {
                padding-left: 60px;
            }

            #sidebar-wrapper {
                width: 40px;
            }

            #togglebutton {
                display: block;
            }

            #wrapper.toggled #navbar-wrapper {
                position: absolute;
                margin-right: -250px;
            }

            #wrapper.toggled #content-wrapper {
                position: absolute;
                margin-right: -250px;
            }

            #navbar-wrapper {
                position: relative;
            }

            #wrapper.toggled {
                padding-left: 250px;
            }

            #content-wrapper {
                position: relative;
                top: 0;
            }

            #wrapper.toggled #navbar-wrapper,
            #wrapper.toggled #content-wrapper {
                position: relative;
                margin-right: 250px;
            }
        }

        @media (max-width: 767px) {
            #wrapper {
                padding-left: 0;
            }

            #sidebar-wrapper {
                width: 0;
            }

            #togglebutton {
                display: block;
            }

            #wrapper.toggled #sidebar-wrapper {
                width: 250px;
            }

            #wrapper.toggled #navbar-wrapper {
                position: absolute;
                margin-right: -250px;
            }

            #wrapper.toggled #content-wrapper {
                position: absolute;
                margin-right: -250px;
            }

            #navbar-wrapper {
                position: relative;
            }

            #wrapper.toggled {
                padding-left: 250px;
            }

            #content-wrapper {
                position: relative;
                top: 0;
            }

            #wrapper.toggled #navbar-wrapper,
            #wrapper.toggled #content-wrapper {
                position: relative;
                margin-right: 250px;
            }
        }
    </style>
</head>

<body>

    <div id="app" class=" overflow-hidden d-flex flex-column w-100 vh-100">
        <nav
            class="navbar navbar-expand-md d-flex flex-row align-items-center  justify-content-around  bg-white shadow-sm">


            <div id="togglebutton">
                <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
            </div>
            <!--Medlink Logo-->
            <div class="text-start cursor-pointer">
                <img src="{{ asset('assets/img/logos/logo.png') }}" alt="Medlink" style="height:40px;">
            </div>
            <!--Date and Time -->
            <div class="text-center d-none d-md-flex gap-2">
                <i class="fa fa-clock" style="font-size:24px"></i> <span id="myDiv"></span>
            </div>
            <!-- User Name and Log out dropdown item-->
            <div class="text-end">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <div class="nav-item  dropdown  show d-flex align-items-center">
                        <a id="navbarDropdown" class="nav-link gap-2 dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if (Auth::user()->profile_picture)
                                <img src="{{ asset('storage/app/public/' . Auth::user()->profile_picture) }}"
                                    alt="Profile Picture" class="rounded-circle"
                                    style="width: 30px; height: 30px; object-fit: cover;">
                            @else
                                {{ Auth::user()->name }}
                            @endif
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile') }}">
                                <div class="d-flex align-items-center">
                                    @if (Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/app/public/' . Auth::user()->profile_picture) }}"
                                            alt="Profile Picture" class="mr-2 rounded-circle"
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                    @endif
                                    <span>{{ Auth::user()->name }}</span>
                                </div>
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

        </nav>
        <div class="d-flex flex-grow-1 overflow-hidden vw-100">

            <div id="wrapper">

                <aside id="sidebar-wrapper"
                    class= 'border-0 border-radius-xl hover:bg-primary navbar-light  p-0 bg-white rounded'>

                    <ul class="sidebar-nav">
                        <li class="{{ Request::is('homeview') ? 'active' : '' }}">
                            <a href="{{ route('homeview') }}">

                                <i class="fa fa-home fa-sm text-left"></i>

                                Home
                            </a>
                        </li>


                        <li class="{{ Request::is('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}">

                                <i class="fa fa-h-square fa-sm text-left "></i>

                                Doctor screen
                            </a>
                        </li>

                        <li class="{{ Request::is('appointmentListView') ? 'active' : '' }}">
                            <a href="{{ route('appointments_view') }}">

                                <i class="fa fa-align-justify fa-sm mr-0"></i>

                                Appoinment

                            </a>
                        </li>
                        <li class="{{ Request::is('drugsListView') ? 'active' : '' }}">
                            <a href="{{ route('drugs_view') }}">
                                <i class="fa fa-medkit"></i>

                                Drugs Manage
                            </a>
                        </li>
                        <li class="{{ Request::is('patient_list_view') ? 'active' : '' }}">
                            <a href="{{ route('patient_list.view') }}">

                                <i class="fa fa-user-o"></i>

                                Patient Manage
                            </a>
                        </li>
                        <li class="{{ Request::is('diagnosticCategoriesListView') ? 'active' : '' }}">
                            <a href="{{ route('diagnosticCategories_view') }}">
                                <i class="fa fa-list"></i> Diagnostic Manage
                            </a>
                        </li>
                        <li class="{{ Request::is('medicalTestView') ? 'active' : '' }}">
                            <a href="{{ route('medical_test_view') }}">

                                <i class="fa fa-stethoscope"></i>

                                Medical Manage
                            </a>
                        </li>
                        <li class="{{ Request::is('helps') ? 'active' : '' }}">
                            <a href="{{ route('helps') }}">
                                <i class="fa fa-question-circle"></i>

                                Helps
                            </a>
                        </li>
                    </ul>
                </aside>

                <!-- Another Componenet-->
            </div>

            <div class="d-flex flex-grow-1 overflow-y-auto">



                <main class="w-100">
                    <div class="position-relative">

                        <div class="position-absolute  z-index-2 top-0 end-0 p-2">
                            <x-tostmessage />
                        </div>
                    </div>
                    <div class="container-fluid py-2">

                        @yield('content')
                    </div>


                </main>
            </div>
        </div>
    </div>

    <script>
        const $button = document.querySelector('#sidebar-toggle');
        const $wrapper = document.querySelector('#wrapper');

        $button.addEventListener('click', (e) => {
            e.preventDefault();
            $wrapper.classList.toggle('toggled');
        });

        function showDateTime() {
            var myDiv = document.getElementById("myDiv");

            var date = new Date();
            var dayList = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
            var monthNames = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ];
            var dayName = dayList[date.getDay()];
            var monthName = monthNames[date.getMonth()];
            var today = `${dayName}, ${monthName} ${date.getDate()}, ${date.getFullYear()}`;

            var hour = date.getHours();
            var min = date.getMinutes();
            var sec = date.getSeconds();

            var time = hour + ":" + min + ":" + sec;
            myDiv.innerText = `${today} ${time}`;
        }
        setInterval(showDateTime, 1000);
    </script>
    <script>
        // A $( document ).ready() block.
        $(document).ready(function() {
            $('.toast').toast('show');
            // alert("okay");
        });
    </script>
</body>

</html>
