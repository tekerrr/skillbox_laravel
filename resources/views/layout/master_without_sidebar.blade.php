@extends('layout.master')

@section('sidebar')
@endsection

@section('body')
    <div class="col-md-12 blog-main">

        <h3 class="pb-3 mb-4 font-italic border-bottom">

            @yield('content_title', \Illuminate\Support\Facades\View::yieldContent('title'))

        </h3>

        @yield('content')

    </div>
@endsection
