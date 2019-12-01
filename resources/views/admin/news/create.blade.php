@extends('layout.master')

@section('title', 'Создание новости')

@section('content')

    @include('layout.errors')

    <form method="post" action="/admin/news">

        @csrf

        @include('layout.form.slug')
        @include('layout.form.title')
        @include('layout.form.abstract')
        @include('layout.form.body')
        @include('layout.form.tags')
        @include('layout.form.is_active')

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Создать новость</button>
        </div>
    </form>

@endsection
