@extends('layout.master')

@section('title', $task->title)

@section('content')
    <p class="blog-post-meta">{{ $task->created_at->toformattedDateString() }}</p>
    {{ $task->body }}

    <hr>
    <a href="/tasks/{{ $task->id }}/edit">Редактировать</a>
    <hr>

    <a href="/tasks">Вернуться к списку задач</a>
@endsection
