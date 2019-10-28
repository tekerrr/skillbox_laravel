@extends('layout.master')

@section('title', 'Главная')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-3 mb-4 font-italic border-bottom">
            Список публикаций
        </h3>
        @foreach($posts as $post)
            @include('posts.item')
        @endforeach
    </div>
@endsection
