@extends('layout.master')

@section('title', 'Редактирование задачи')

@section('content')

    @include('layout.errors')

    <form method="POST" action="/tasks/{{ $task->id }}">

        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="inputTitle">Название задачи</label>
            <input type="text" class="form-control" id="inputTitle" placeholder="Введите название задачи"
                   name="title"
                   value="{{ old('title', $task->title) }}">
        </div>

        <div class="form-group">
            <label for="inputBody">Описание задачи</label>
            <textarea class="form-control" id="inputBody" name="body">{{ old('body', $task->body) }}</textarea>
        </div>

        <div class="form-group">
            <label for="inputTags">Теги</label>
            <input type="text" class="form-control" id="inputTags" placeholder="Введите теги"
                   name="tags"
                   value="{{ old('tags', $task->tags->pluck('name')->implode(', ')) }}">
        </div>

        <button type="submit" class="btn btn-primary">Изменить задачу</button>

    </form>

    <form method="POST" action="/tasks/{{ $task->id }}">

        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger my-3">Удалить задачу</button>

    </form>

@endsection
