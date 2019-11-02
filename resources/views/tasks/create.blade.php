@extends('layout.master')

@section('title', 'Создание задачи')

@section('content')

    @include('layout.errors')

    <form method="POST" action="/tasks">

        @csrf

        <div class="form-group">
            <label for="inputTitle">Название задачи</label>
            <input type="text" class="form-control" id="inputTitle" placeholder="Введите название задачи"
                   name="title"
                   value="{{ old('title') }}">
        </div>

        <div class="form-group">
            <label for="inputBody">Описание задачи</label>
            <textarea class="form-control" id="inputBody" name="body">{{ old('body') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Создать задачу</button>

    </form>

@endsection
