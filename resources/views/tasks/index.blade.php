@extends('layout.master')

@section('title', 'Задачи')

@section('content')
    @foreach($tasks as $task)
        @include('tasks.item')
    @endforeach

    <a href="/tasks/create">Создать задачу</a>
@endsection
