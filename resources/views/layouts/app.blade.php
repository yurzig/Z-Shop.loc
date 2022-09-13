<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
    @stack('meta')

    <!-- Styles -->
{{--    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    {{--        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">--}}
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}"/>--}}
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('css/slick-theme.css') }}"/>--}}
{{--    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/css/suggestions.min.css" rel="stylesheet" />--}}
    {{--    <link href='{{ url('sitemap.xml') }}' rel='alternate' title='Sitemap' type='application/rss+xml'/>--}}
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>
<body>
@include('layouts._header')
@yield('content')
{{--@include('layouts._footer')--}}
<!-- Scripts -->
{{--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>--}}

{{--<script src="{{ asset('js/jquery-3.6.0.min.js') }}" defer></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>--}}
{{--<script src="{{ asset('js/jquery-ui.min.js') }}" defer></script>--}}
{{--<script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>--}}
{{--<script src="{{ asset('js/slick.min.js') }}" defer></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>--}}
{{--<script src="{{ asset('js/main.js') }}" defer></script>--}}
{{--@include('includes._scripts')--}}
@stack('scripts')

</body>
</html>
