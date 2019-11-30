@extends('layout.master')

@section('title', 'Задачи')

@section('content')
{{--    @foreach($tasks as $task)--}}
{{--        @include('tasks.item')--}}
{{--    @endforeach--}}
    @each('tasks.item', $tasks, 'task', 'tasks.empty')

    {{ $tasks->links() }}
{{--    {{ $tasks->links('pagination.view', ['some' => 'data']) }}--}}
{{--    {{ $tasks->appends(['sort' => 'title'])->fragment('foobar')->onEachSide(1)->links() }}--}}


    <a href="/tasks/create">Создать задачу</a>
@endsection
