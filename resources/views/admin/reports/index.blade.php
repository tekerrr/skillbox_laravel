@extends('layout.master_without_sidebar')

@section('title', 'Отчёты')

@section('content')
    <ul>
        <li><a href="{{ route('admin.reports.total') }}">Итого</a></li>
        <li><a href="{{ route('admin.reports.files') }}">Сохранённые отчеты</a></li>
    </ul>
@endsection
