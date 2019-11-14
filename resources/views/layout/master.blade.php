<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Skillbox Laravel')</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link href="/css/blog.css" rel="stylesheet">
    <style>
        .completed {
            text-decoration: line-through;
        }
    </style>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>

<body>

@include('layout.nav')

    <main role="main" class="container" id="app">
{{--        <div class="row">--}}
{{--            <example-component></example-component>--}}
{{--        </div>--}}

        @include('layout.flash_message')

{{--        @component('components.alert', ['type' => 'success'])--}}
{{--            @slot('title')--}}
{{--                Ууууупс--}}
{{--            @endslot--}}

{{--            <b>Что-то</b> пошло не так--}}
{{--        @endcomponent--}}

{{--        @alert(['type' => 'success'])--}}
{{--            @slot('title')--}}
{{--                Ууууупс--}}
{{--            @endslot--}}

{{--            <b>Что-то</b> пошло не так--}}
{{--        @endalert--}}

        <div class="row">

            @section('body')
                <div class="col-md-8 blog-main">

                    <h3 class="pb-3 mb-4 font-italic border-bottom">

                        @yield('content_title', \Illuminate\Support\Facades\View::yieldContent('title'))

                    </h3>

                    @yield('content')

                </div>
            @show

            @section('sidebar')
                @include('layout.sidebar')
            @show

        </div>

    </main>

    @include('layout.footer')
{{--    <script src="{{ mix ('/js/manifest.js') }}"></script>--}}
{{--    <script src="{{ mix('/js/vendor.js') }}"></script>--}}
{{--    <script src="{{ mix('/js/app.js') }}"></script>--}}
</body>
</html>
