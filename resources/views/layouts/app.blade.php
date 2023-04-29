{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
    <link rel="stylesheet" type="text/css" href="styles/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="styles/owl.theme.default.min.css">
    @stack('styles')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>
</html> --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('styles/index.min.css')}}" />
    <link href="{{ asset('https://fonts.googleapis.com/icon?family=Material+Icons')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css')}}">
    <link rel="stylesheet" href="{{ asset('https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap')}}">

    {{-- <link
        rel="stylesheet"
        href="{{ asset('https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css')}}" /> --}}

    <link rel="stylesheet" type="text/css" href="{{ asset('styles/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('styles/owl.theme.default.min.css')}}">

    @stack('styles')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class=" grid 2xl:grid-cols-12 xl:grid-cols-12 lg:grid-cols-1 md:grid-cols-1 sm:grid-cols-1 xs:grid-cols-1  gap-1">
            <div class="  2xl:col-span-2  xl:col-span-2 lg:mr-2 xl:mr-2 sm:mb-2 md:row-span-2 ">
                @include('layouts.navigation')
            </div>
            <div class="  2xl:col-span-10 xl:col-span-10 md:row-span-10  pt-2 pl-2 pr-2  xs:px-0">
                {{ $slot }}

            </div>



        </div>


    </div>

    @livewireScripts()
    <script type="text/javascript">
        function dropdown() {
            document.querySelector("#submenu").classList.toggle("hidden");
            document.querySelector("#arrow").classList.toggle("rotate-0");
        }
        dropdown();

        function openSidebar() {
            document.querySelector(".sidebar").classList.toggle("hidden");
        }

    </script>

    <script src="{{ asset('js/jquery.min.js')}}"></script>
    <script src="{{ asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>

    <link href="{{ asset('https://fonts.googleapis.com/icon?family=Material+Icons')}}" rel="stylesheet">
    <script src="{{ asset('js/Chart.min.js')}}"></script>
    <script src="{{ asset('js/cropper.min.js')}}"></script>
    <script src="{{ asset('js/index.min.js') }}"></script>
    <script src="{{ asset('js/flowbite.min.js')}}"></script>

    <script src="{{ asset('js/sort-list.js')}}"></script>




    <script>
        $('.owl-dashboard').owlCarousel({
            loop: false
            , margin: 10
            , nav: true
            , responsiveClass: true,
            // navText: ["<div class=''><</div>", "<div class=''>></div>"],

            responsive: {
                0: {
                    items: 1
                }
                , 600: {
                    items: 2
                }
                , 1000: {
                    items: 2
                }
                , 1800: {
                    items: 3
                }
            }
        })
        $('.owl-survey').owlCarousel({
            loop: false,

            margin: 10
            , nav: true
            , responsiveClass: true,
            // navText: ["<div class=''><</div>", "<div class=''>></div>"],

            responsive: {
                0: {
                    items: 1
                }
                , 600: {
                    items: 2
                }
                , 1000: {
                    items: 4
                }
                , 1800: {
                    items: 7
                }
            }
        })

    </script>



    {{-- menubar for each survey in owl carousel  --}}



    @stack('scripts')
    @stack('modals')
</body>

</html>
