@extends('layout.master')

@section('title', 'Список обращений')

@section('content')
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
@endsection
