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
        <div class="form-group">
            <label for="inputTags">Теги </label>
            <input type="text" class="form-control" id="inputTags" placeholder="Введите теги (разделитель &quot;, &quot;)"
                   name="tags"
                   value="{{ old('tags', $post->tags->pluck('name')->implode(', ')) }}">
        </div>
        <div class="form-group form-check">
            <input class="form-check-input" type="checkbox" id="checkboxActive" value="1"
                   name="is_active"  {{ (old('is_active') || (!old('_token') && $post->isActive())) ? 'checked' : '' }}>
            <label class="form-check-label" for="checkboxActive">Опубликовать</label>
        </div>
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
