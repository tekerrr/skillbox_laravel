@extends('layout.master')

@section('title', 'Контакты')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-3 mb-4 font-italic border-bottom">
            Контакты
        </h3>
        <p>Какие-то контакты</p>
        <hr>
        <p>Хотите связаться с нима, просто напишите</p>

        @include('feedback.form')
    </div>
@endsection
