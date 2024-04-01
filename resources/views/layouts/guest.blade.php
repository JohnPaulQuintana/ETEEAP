<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap core CSS -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/css/bootstrap.min.css" /> --}}
    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/css/bootstrap.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- font awesome --}}
    <link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
        href="/css/app-wa-462d1fe84b879d730fe2180b0e0354e0.css?vsn=d">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-light.css">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900"
        rel="stylesheet">

        {{-- Check if the current URL contains 'reset-password' --}}
        @if (Str::contains(Request::url(), 'reset-password'))
            <link rel="stylesheet" href="{{ asset(str_replace('reset-password/', '', 'assets/css/templatemo-grad-school.css')) }}">
            <link rel="stylesheet" href="{{ asset(str_replace('reset-password/', '', 'assets/css/owl.css')) }}">
            <link rel="stylesheet" href="{{ asset(str_replace('reset-password/', '', 'assets/css/lightbox.css')) }}">
        @else
            <link rel="stylesheet" href="{{ asset('assets/css/templatemo-grad-school.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">
            <link rel="stylesheet" href="{{ asset('assets/css/lightbox.css') }}">
        @endif 
</head>

<body class="font-sans">
    {{-- <h1>{{ Str::contains(Request::url(), 'reset-password') }}</h1> --}}
    {{-- <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div> --}}
    <!--header-->
    <header class="main-header clearfix" role="header">
        <div class="logo">
            <a href="#" class="flex items-center gap-2">
                @if (Str::contains(Request::url(), 'reset-password'))
                    <img class="w-12 h-12" src="{{ asset(str_replace('reset-password/', '', './assets/images/logo.png')) }}" alt="" srcset="">
                @else

                    <img class="w-12 h-12" src="./assets/images/logo.png" alt="" srcset="">
                @endif
                
                <em>ETEEAP</em>
            </a>
        </div>
        <a class="menu-link hover:cursor-pointer"><i class="fa fa-bars"></i></a>
        <nav id="menu" class="main-nav" role="navigation">
            <ul class="main-menu">
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li class="has-submenu">
                    <li><a href="{{ route('login') }}">Login</a></li>
                </li>
                <li><a class="border border-white" href="{{ route('register') }}">Apply Now</a></li>
            </ul>
        </nav>
    </header>
    <!-- ***** Main Banner Area Start ***** -->
    <section class="section main-banner" id="top" data-section="section1">
        <img id="bg-video" class="mt-21" src="{{ asset('images/background2.jpg') }}" alt="" srcset="">
        {{-- <video autoplay muted loop id="bg-video">
            <source src="assets/images/course-video.mp4" type="video/mp4" />
        </video> --}}

    </section>
    <!-- ***** Main Banner Area End ***** -->
    <main class="flex items-center justify-center">
        <div class="video-overlay header-text grid grid-cols-1 md:grid-cols-2">
            <div class="flex flex-col justify-center items-center mt-29">
                <h6 class="font-bold text-xl md:text-2xl text-white">Application Tracking System</h6>
                <h6 class="font-bold text-xl md:text-2xl text-white mt-3">for the</h6>
                <h2 class="mt-1 font-bold text-4xl md:text-6xl text-textprimary uppercase not-italic">ETEEAP program</h2>
                <div class="main-button mt-2">
                    <div class="scroll-to-section"><a class="b-r hover:cursor-pointer">Program Details</a></div>
                </div>
            </div>
            <div class="flex justify-center items-center">
                {{ $slot }}
            </div>
        </div>
    </main>

    @include('popup.requirement')

    <!-- Bootstrap core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/js/bootstrap.min.js"></script>

    @if (Str::contains(Request::url(), 'reset-password'))
        <script src="{{ asset(str_replace('reset-password/', '', 'assets/js/isotope.min.js'))}}"></script>
        <script src="{{ asset(str_replace('reset-password/', '', 'assets/js/owl-carousel.js')) }}"></script>
        <script src="{{ asset(str_replace('reset-password/', '', 'assets/js/lightbox.js')) }}"></script>
        <script src="{{ asset(str_replace('reset-password/', '', 'assets/js/tabs.js')) }}"></script>
        <script src="{{ asset(str_replace('reset-password/', '', 'assets/js/video.js')) }}"></script>
        <script src="{{ asset(str_replace('reset-password/', '', 'assets/js/slick-slider.js')) }}"></script>
        <script src="{{ asset(str_replace('reset-password/', '', 'assets/js/custom.js')) }}"></script>
    @else
        <script src="assets/js/isotope.min.js"></script>
        <script src="assets/js/owl-carousel.js"></script>
        <script src="assets/js/lightbox.js"></script>
        <script src="assets/js/tabs.js"></script>
        <script src="assets/js/video.js"></script>
        <script src="assets/js/slick-slider.js"></script>
        <script src="assets/js/custom.js"></script>
    @endif
    
    <script>
        $(document).ready(function() {
            //according to loftblog tut
            $('.nav li:first').addClass('active');

            

            // requirements
            // set the modal menu element
            const $requirementM = document.getElementById('requirement-modal');
            // options with default values
            const options = {
                placement: 'bottom-right',
                backdrop: 'static',
                backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
                closable: true,
                onHide: () => {
                    console.log('modal is hidden');
                },
                onShow: () => {
                    console.log('modal is shown');
                },
                onToggle: () => {
                    console.log('modal has been toggled');
                },
            };

            // instance options object
            const instanceOptions = {
                id: 'requirement-modal',
                override: true
            };
            // on load
            const rq = new Modal($requirementM, options, instanceOptions);

            // rq.show()

            $('.b-r').on('click', function() {

                rq.show()
            })
        })
    </script>
</body>


</html>
