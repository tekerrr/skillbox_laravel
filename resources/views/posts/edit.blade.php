@extends('layout.master')

@section('title', 'Редактирование статьи')

@section('content')

    @include('layout.errors')

    <form method="POST" action="{{ route('posts.update', compact('post')) }}">

        @csrf
        @method('PATCH')

        @include('layout.input.slug', ['default' => $post->slug])
        @include('layout.input.title', ['default' => $post->title])
        @include('layout.input.abstract', ['default' => $post->abstract])
        @include('layout.input.body', ['default' => $post->body])
        @include('layout.input.tags', ['default' => $post->tags->pluck('name')->implode(', ')])
        @include('layout.input.is_active', ['default' => $post->isActive()])

        @include('layout.input.submit', ['text' => 'Обновить'])

    </form>

    <form method="POST" action="{{ route('posts.destroy', compact('post')) }}">
        @csrf
        @method('DELETE')

        @include('layout.input.submit', ['text' => 'Удалить', 'type' => 'outline-danger'])
    </form>

@endsection
