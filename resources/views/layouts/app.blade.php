<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>চালকলের মিলিং ক্ষমতা নির্ণয় </title>


    <!-- Scripts -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/dropdown.js') }}" defer></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

    <!-- Scripts ks -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />

    {{-- <!-- Styles --> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    @livewireStyles
</head>

<body>
    <div id="app" style="min-height:97.5vh">
        <div id="header_div">
            <div id="head_left"><img align="middle" src="{{ asset('images/logo_DGF.png') }}" width="60%" height="60%" /></div>
            <div id="head_mid" >
                <h1 align="center">চালকলের মিলিং ক্ষমতা নির্ণয়</h1>
                {{-- <p>খাদ্য অধিদপ্তর</p> --}}
            </div>

            <div id="head_left"></div>
        </div>

        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                @auth
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/home">হোম</a>
                    </li>
                </ul>
                @endauth
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav mr-auto">
                        @if(DGFAuth::check(1000, 1, 1))
                            <li class="nav-item dropdown"> <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> ফরম <span class="caret"></span></a>
                                <ul class="dropdown-menu flex justify-content-end" style="width:280px">
                                    @if(DGFAuth::check(1010, 1, 1))
                                    <li class="nav-item"><a class="nav-link" href="/millers/create?option=form2" >অটোমেটিক চালকলের তথ্য ফরম</a></li>
                                    @endif
                                    @if(DGFAuth::check(1040, 1, 1))
                                    <li class="nav-item"><a class="nav-link" href="/millers/create?option=form1" >সেমি-অটোমেটিক চালকলের তথ্য ফরম</a></li>
                                    @endif
                                    @if(DGFAuth::check(1030, 1, 1))
                                    <li class="nav-item"><a class="nav-link" href="/millers/create?option=form4" >রাবার শেলার যুক্ত (মেজর) চালকলের তথ্য ফরম</a></li>
                                    @endif
                                    @if(DGFAuth::check(1020, 1, 1))
                                    <li class="nav-item"><a class="nav-link" href="/millers/create?option=form3" >রাবার শেলার বিহীন (হাস্কিং) চালকলের তথ্য ফরম</a></li>
                                    @endif
                                    @if(DGFAuth::check(1050, 1, 1))
                                    <li class="nav-item"><a class="nav-link" href="/millers/create?option=form5" >হালনাগাদকৃত অটোমেটিক চালকলের তথ্য ফরম</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        @if(DGFAuth::check(2000, 2, 2))
                        <li class="nav-item"><a class="nav-link" href="/manageusers">ম্যানেজ ইউজার</a></li>
                        @endif
                        @if(DGFAuth::check(3000))
                        <li class="nav-item"><a class="nav-link" href="/reports">প্রতিবেদন</a></li>
                        @endif
                        @if(DGFAuth::check(4000, 1, 2))
                        <li class="nav-item"><a class="nav-link" href="/millers">নিয়ন্ত্রন</a></li>
                        @endif
                        @if(DGFAuth::check(5000))
                            <li class="nav-item"><a class="nav-link" href="/configuration">কনফিগারেশন</a></li>
                        @endif
                        @if(DGFAuth::check(4000, 1, 2) && Auth::user()->user_type <> 6) 
                            <li class="nav-item"><a class="nav-link" href="/millers.list?cmp_status=0">অসম্পূর্ন তথ্য</a></li>
                        @endif                        
                    </ul>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                          <a target="_blank" class="nav-link" href="{{ asset('manual/Milling Capacity- General User Manual.pdf') }}">{{ __('ইউজার ম্যানুয়াল') }}</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{ route('millerregister.index') }}">{{ __('আমার মিল') }}</a>
                        </li>
                        @if (Route::has('register'))
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('চালকলের আবেদন') }}</a>
                        </li> --}}
                        @if(DGFAuth::checkregistration())
                        <li class="nav-item dropdown"> <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> {{ __('চালকলের আবেদন') }} <span class="caret"></span></a>
                            <ul class="dropdown-menu flex justify-content-end" style="width:200px">
                                <!-- <li class="nav-item"><a class="nav-link" href="{{ route('millerregister.create', ['option=form2'])}}" >অটোমেটিক চালকলের তথ্য ফরম</a></li>-->
                                <li class="nav-item"><a class="nav-link" href="{{ route('millerregister.create', ['option=form1'])}}" >সেমি-অটোমেটিক চালকলের তথ্য ফরম</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('millerregister.create', ['option=form4'])}}" >রাবার শেলার যুক্ত (মেজর) চালকলের তথ্য ফরম</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('millerregister.create', ['option=form3'])}}" >রাবার শেলার বিহীন (হাস্কিং) চালকলের তথ্য ফরম</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('millerregister.create', ['option=form5'])}}" >হালনাগাদকৃত অটোমেটিক চালকলের তথ্য ফরম</a></li>
                            </ul>
                        </li>
                        @endif
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('লগ-ইন') }}</a>
                        </li>
                        @else
                        <li class="nav-item">
                          <a target="_blank" class="nav-link" href="{{ asset('manual/Milling Capacity- Admin User Manual.pdf') }}">{{ __('এডমিন ইউজার ম্যানুয়াল') }}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                                @if(Auth::user()->avatar)
                                <img src="{{asset('/storage/images/'.Auth::user()->avatar)}}" alt="avatar" width="40" />
                                @endif
                                 <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu flex justify-content-end" style="width:280px">
                                <li class="nav-item"><a class="nav-link" href="/myprofile" >ইউজারের তথ্য</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('changepassword') }}" >পাসওয়ার্ড পরিবর্তন</a></li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">লগ আউট</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="mb-5 p-4">
            @yield('content')
        </main>
    </div>
    <div id="footer_div" style="">
        কপিরাইট © কম্পিউটার নেটওয়ার্ক ইউনিট, খাদ্য অধিদপ্তর, ১৬ আব্দুল গনি রোড ,ঢাকা-১০০০. ই-মেইল : info@dgfood.gov.bd
        <br/>
        <div class="text-xs" style="margin-top: -5px;">Develeoped by AccenTech Ltd. www.accentechltd.com</span>
    </div>

    @livewireScripts

    <script type="text/javascript">

        $('.date').datepicker({

           format: 'yyyy-mm-dd'

         });

    </script>
</body>

</html>
