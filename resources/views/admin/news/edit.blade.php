@extends('layout.master')

@section('title', 'Редактирование новости')

@section('content')

    @include('layout.errors')

    <form method="POST" action="{{ route('admin.news.update', compact('news')) }}">

        @csrf
        @method('PATCH')

        @include('layout.input.slug', ['default' => $news->slug])
        @include('layout.input.title', ['default' => $news->title])
        @include('layout.input.abstract', ['default' => $news->abstract])
        @include('layout.input.body', ['default' => $news->body])
        @include('layout.input.tags', ['default' => $news->tags->pluck('name')->implode(', ')])
        @include('layout.input.is_active', ['default' => $news->isActive()])

        @include('layout.input.submit', ['text' => 'Обновить'])

    </form>

    <form method="POST" action="{{ route('admin.news.destroy', compact('news')) }}">
        @csrf
        @method('DELETE')

        @include('layout.input.submit', ['text' => 'Удалить', 'type' => 'outline-danger'])
    </form>

@endsection
