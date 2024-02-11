<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} @yield('title')</title>

    <!-- Styles -->
    {{--    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/summernote-lite.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    @vite('resources/css/select2-yz.css')
    @vite('resources/css/admin.css')
    @stack('styles')
    {{--    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">--}}
    {{--    <link rel="stylesheet" href="{{ asset('css/common.css') }}">--}}
    {{--    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">--}}
    {{--    <link rel="stylesheet" href="{{ asset('css/nav.css') }}">--}}
    {{--    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">--}}

    {{--    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/css/suggestions.min.css" rel="stylesheet" />--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>--}}
</head>
<body class="admin {{ ( $_COOKIE['grand_backend_theme'] ?? '' ) == 'dark' ? 'dark' : 'light' }}">
<div class="container-fluid">
    <header class="row flex-md-nowrap">
        <div class="col-md-3 col-lg-2 px-3 d-flex justify-content-between">
            <div>
                <button class="navbar-toggler icon d-md-none collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>

                <i class="icon btn-theme light-mode fa fa-sun-o" title="Тема. Светлая"></i>
                <i class="icon btn-theme dark-mode fa fa-moon-o" title="Тема. Темная"></i>
            </div>
            <a href="/" title="На сайт">
                <img src="/images/logo.png" height="36px" alt="логотип">
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                <button class="icon logout fa fa-sign-out" title="Выйти"></button>
            </form>
        </div>
        <div class="header-wrapper col-md-9 col-lg-10">
            <div class="header-content">
                @yield('header-block')
            </div>
        </div>
    </header>
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block ps-3 pe-0 pl-sidebar collapse">
            @include('admin.includes._nav')
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10">
            @yield('content')
        </main>
    </div>
</div>

<!-- Scripts -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>--}}
<script src="{{ asset('js/jquery-3.6.0.min.js') }}" defer></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
<script src="{{ asset('js/flatpickr.min.js') }}" defer></script>
<script src="{{ asset('js/flatpickr-ru.js') }}" defer></script>
<script src="{{ asset('js/summernote-lite.min.js') }}" defer></script>
<script src="{{ asset('js/lang/summernote-ru-RU.min.js') }}" defer></script>
<script src="{{ asset('js/select2/select2.min.js') }}" defer></script>
<script src="{{ asset('js/select2/i18n/ru.js') }}" defer></script>
@vite('resources/js/app.js')
@stack('scripts')

{{--<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>--}}

{{--<script src="{{ asset('js/admin.js') }}" defer></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>--}}


</body>
</html>
