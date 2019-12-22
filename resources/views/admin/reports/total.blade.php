@extends('layout.master_without_sidebar')

@section('title', 'Отчёт: Итого')

@section('content')
    <p>Подсчёт количества:</p>
    <form method="post" action="{{ route('admin.reports.total.store') }}">

        @csrf

        @include('layout.input.switch', ['name' => 'news', 'text' => 'Новостей', 'checked' => true])
        @include('layout.input.switch', ['name' => 'posts', 'text' => 'Статей', 'checked' => true])
        @include('layout.input.switch', ['name' => 'comments', 'text' => 'Комментариев', 'checked' => true])
        @include('layout.input.switch', ['name' => 'tags', 'text' => 'Тегов', 'checked' => true])
        @include('layout.input.switch', ['name' => 'users', 'text' => 'Пользователей', 'checked' => true])
        @include('layout.input.submit', ['text' => 'Сгенерировать отчет'])
    </form>
@endsection
