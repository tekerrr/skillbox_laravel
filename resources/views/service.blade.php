@extends('layout.master')

@section('title', 'Отправить уведомление')

@section('content')

    @include('layout.errors')

    <form method="POST" action="/service">

        @csrf

        <div class="form-group">
            <label for="inputTitle">Заголовок уведомления</label>
            <input type="text" class="form-control" id="inputTitle" placeholder="Введите заголовк"
                   name="title"
                   value="{{ old('title') }}">
        </div>

        <div class="form-group">
            <label for="inputText">Текст уведомления</label>
            <textarea class="form-control" id="inputText" name="text">{{ old('text') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Отправить</button>

    </form>

@endsection
