@extends('layout.master_without_sidebar')

@section('title', 'Административный раздел')

@section('content')
    <ul>
        <li><a href="{{ route('admin.posts.index') }}">Список статей</a></li>
        <li><a href="{{ route('admin.news.index') }}">Список новостей</a></li>
        <li><a href="{{ route('admin.feedback.index') }}">Список обращений</a></li>
        <li><a href="{{ route('admin.statistics.index') }}">Статистика портала</a></li>
        <li><a href="{{ route('admin.reports.index') }}">Отчёты</a></li>
    </ul>
@endsection
