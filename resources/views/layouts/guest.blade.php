<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col  justify-start items-center pt-6 sm:pt-0  dark:bg-gray-900">
            <div>
                <a href="/">
                    <img class="w-48 h-24 object-contain" viewbox="0 0 58 58" fill="none" src="{{asset('images/logo_1_transparent.png')}}" alt="">
                </a>
            </div>

            <div class="w-full 2xl:max-w-md mt-6 px-6 py-4 bg-bg_container dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        
    </body>
</html>
