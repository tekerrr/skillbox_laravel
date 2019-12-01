@extends('layout.master_without_sidebar')

@section('title', 'Административный раздел')

@section('content')
    <ul>
        <li><a href="/admin/posts">Список статей</a></li>
        <li><a href="/admin/news">Список новостей</a></li>
        <li><a href="/admin/feedback">Список обращений</a></li>
    </ul>
@endsection
