@extends('layout.master')

@section('title', 'Главная')
@section('content_title', 'Список новостей и публикаций по тегу')

@section('content')
    @foreach($news as $oneNews)
        @include('news.item', ['news' => $oneNews])
    @endforeach

    @foreach($posts as $post)
        @include('posts.item')
    @endforeach
@endsection
