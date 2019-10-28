@extends('layout.master')

@section('title', 'Главная')
@section('content_title', 'Список публикаци')

@section('content')
    @foreach($posts as $post)
        @include('posts.item')
    @endforeach
@endsection
