@extends('layout.master')

@section('title', 'Задачи')

@section('content')
    <ul>
        @foreach($tasks as $task)
            <li><a href="/tasks/{{ $task->id }}">{{ $task->title }}</a> </li>
        @endforeach
    </ul>
    <a href="/tasks/create">Создать задачу</a>
@endsection
