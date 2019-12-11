@extends('layout.master')

@section('title', 'Главная')
@section('content_title', 'Публикации')

@section('content')
    @foreach($posts as $post)
        @include('posts.item')
    @endforeach

    {{ $posts->links('pagination.view') }}
@endsection
