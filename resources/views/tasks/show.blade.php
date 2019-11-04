@extends('layout.master')

@section('title', $task->title)

@section('content')
    <p class="blog-post-meta">{{ $task->created_at->toformattedDateString() }}</p>

    @include('tasks.tags', ['tags' => $task->tags])

    {{ $task->body }}

    @if ($task->steps->isNotEmpty())
        <ul class="list-group">
            @foreach($task->steps as $step)
                <li class="list-group-item">
                    <form method="POST" action="/completed-steps/{{ $step->id }}">
                        @csrf
                        @if ($step->completed)
                            @method('DELETE')
                        @endif
                        <div class="form-check">
                            <label class="form-check-label {{ $step->completed ? 'completed' : '' }}">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="completed"
                                    onclick="this.form.submit()"
                                    {{ $step->completed ? 'checked' : '' }}
                                >
                                {{ $step->description }}
                            </label>
                        </div>
                    </form>
                </li>
           @endforeach
        </ul>
    @endif

    <form class="card card-body mb-4" method="POST" action="/tasks/{{ $task->id }}/steps">
        @csrf

        <div class="form-group">
            <input
                type="text"
                class="form-control"
                placeholder="Шаг"
                value="{{ old('description') }}"
                name="description"
            >
        </div>
        <button type="submit" class="btn btn-primary">Добавить</button>

    </form>

    @include('layout.errors')

    @can('update', $task)
        <hr>
        <a href="/tasks/{{ $task->id }}/edit">Редактировать</a>
    @endcan

    <hr>
    <a href="/tasks">Вернуться к списку задач</a>
@endsection
