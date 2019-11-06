@extends('layout.master')

@section('title', 'Редактирование статьи')

@section('content')

    @include('layout.errors')

    <form method="POST" action="/posts/{{ $post->slug }}">

        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="inputSlug">Символьный код</label>
            <input type="text" class="form-control" id="inputSlug" placeholder="Введите символьный код"
                   name="slug"
                   value="{{ old('slug', $post->slug) }}">
        </div>
        <div class="form-group">
            <label for="inputTitle">Название статьи</label>
            <input type="text" class="form-control" id="inputTitle" placeholder="Введите название статьи"
                   name="title"
                   value="{{ old('title', $post->title) }}">
        </div>
        <div class="form-group">
            <label for="inputAbstract">Краткое описание статьи</label>
            <textarea class="form-control" id="inputAbstract" rows="3" name="abstract">{{ old('abstract', $post->abstract) }}</textarea>
        </div>
        <div class="form-group">
            <label for="inputBody">Детальное описание стати</label>
            <textarea class="form-control" id="inputBody" rows="3" name="body">{{ old('body', $post->body) }}</textarea>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="checkboxPublished" value="1"
                   name="published"  {{ (old('published') || (!old('_token') && $post->published)) ? 'checked' : '' }}>
            <label class="form-check-label" for="checkboxPublished">Опубликовано</label>
        </div>
        <button type="submit" class="btn btn-primary">Обновить статью</button>
    </form>

    <form method="POST" action="/posts/{{ $post->slug }}">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger my-3">Удалить статью</button>
    </form>

@endsection
