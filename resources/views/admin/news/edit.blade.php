@extends('layout.master')

@section('title', 'Редактирование новости')

@section('content')

    @include('layout.errors')

    <form method="POST" action="/admin/news/{{ $news->slug }}">

        @csrf
        @method('PATCH')

        @include('layout.form.slug', ['default' => $news->slug])
        @include('layout.form.title', ['default' => $news->title])
        @include('layout.form.abstract', ['default' => $news->abstract])
        @include('layout.form.body', ['default' => $news->body])
        @include('layout.form.tags', ['default' => $news->tags->pluck('name')->implode(', ')])
        @include('layout.form.is_active', ['default' => $news->isActive()])

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Обновить</button>
        </div>
    </form>

    <form method="POST" action="/admin/news/{{ $news->slug }}">
        @csrf
        @method('DELETE')

        <div class="form-group">
            <button type="submit" class="btn btn-outline-danger">Удалить</button>
        </div>
    </form>

@endsection
