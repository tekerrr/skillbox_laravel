@extends('layout.master')

@section('title', 'Контакты')

@section('content')
    <p>Какие-то контакты</p>
    <hr>
    <p>Хотите связаться с нима, просто напишите</p>

    @include('feedback.form')
@endsection
