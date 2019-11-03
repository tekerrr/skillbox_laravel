<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
</head>

<body>

@include('layout.nav')

    <main role="main" class="container">

        <div class="row">

            <div class="col-md-8 blog-main">

                <h3 class="pb-3 mb-4 font-italic border-bottom">

                    @yield('content_title', \Illuminate\Support\Facades\View::yieldContent('title'))

                </h3>

                @yield('content')

            </div>

            @include('layout.sidebar')

        </div>

    </main>

    @include('layout.footer')

</body>
</html>
