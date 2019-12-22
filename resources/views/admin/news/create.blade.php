@extends('layout.master')

@section('title', 'Создание новости')

@section('content')

    @include('layout.errors')

    <form method="post" action="{{ route('admin.news.store') }}">

        @csrf

        @include('layout.input.slug')
        @include('layout.input.title')
        @include('layout.input.abstract')
        @include('layout.input.body')
        @include('layout.input.tags')
        @include('layout.input.is_active')

        @include('layout.input.submit', ['text' => 'Создать новость'])

    </form>

@endsection
