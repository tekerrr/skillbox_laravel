@extends('layout.master')

@section('title', 'Редактирование статьи')

@section('content')

    @include('layout.errors')

    <form method="POST" action="/posts/{{ $post->slug }}">

        @csrf
        @method('PATCH')

        @include('layout.form.slug', ['default' => $post->slug])
        @include('layout.form.title', ['default' => $post->title])
        @include('layout.form.abstract', ['default' => $post->abstract])
        @include('layout.form.body', ['default' => $post->body])
        @include('layout.form.tags', ['default' => $post->tags->pluck('name')->implode(', ')])
        @include('layout.form.is_active', ['default' => $post->isActive()])

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Обновить</button>
        </div>
    </form>

    <form method="POST" action="/posts/{{ $post->slug }}">
        @csrf
        @method('DELETE')

        <div class="form-group">
            <button type="submit" class="btn btn-outline-danger">Удалить</button>
        </div>
    </form>

@endsection
