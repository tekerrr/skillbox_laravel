@extends('layout.master_without_sidebar')

@section('title', 'Отчёты')

@section('content')
    <ul>
        <li><a href="{{ route('admin.reports.total') }}">Итого</a></li>
    </ul>
@endsection
