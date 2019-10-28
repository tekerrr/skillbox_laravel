@extends('layout.master')

@section('title', 'Список обращений')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-3 mb-4 font-italic border-bottom">
            Список обращений
        </h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Email</th>
                <th scope="col">Сообщение</th>
                <th scope="col">Дата получения</th>
            </tr>
            </thead>
            <tbody>
            @foreach($feedbacks as $feedback)
                <tr>
                    <th scope="row">{{ $feedback->id }}</th>
                    <td>{{ $feedback->email }}</td>
                    <td>{{ $feedback->body }}</td>
                    <td>{{ $feedback->created_at->toformattedDateString() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
