<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('styles/owl.carousel.min.css')}}">

        @stack('styles')

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>

        <div style="overflow:hidden">
            @livewire('survey-template')
        </div>






@livewireScripts()
<script src="{{ asset('js/jquery.min.js')}}" ></script>
<script src="{{ asset('js/owl.carousel.min.js')}}"></script>
<script>
            $('.owl-carousel').owlCarousel({
        loop:true,
        nav:false,
        autoplay:true,
        autoplayTimeout: 6000,

        smartSpeed: 450,

        // animateOut: 'slideOutDown',
        animateOut: 'fadeOut',
        items:1,
        margin:30,
        center:true,
        touchDrag  : false,
        mouseDrag  :false,
        onTranslate: function (event) {
        $('.owl-item').removeClass('animated');

    },


    })
</script>

@stack('scripts')
    </body>
</html>
