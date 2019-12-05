@extends('layout.master_without_sidebar')

@section('title', 'Статистика портала')

@section('content')
    @if ($data->isNotEmpty())
        <ul>
            <li>Общее количество статей: {{ $data['posts']['number'] }}</li>
            <li>Общее количество активных статей: {{ $data['activePosts']['number'] }}</li>
            <li>Общее количество новостей: {{ $data['news']['number'] }}</li>
            <li>Общее количество активных новостей: {{ $data['activeNews']['number'] }}</li>
            <li>ФИО автора, у которого больше всего статей на сайте: {{ $data['mostProductiveAuthor']['name'] }}</li>
            <li>Самая длинная статья:
                <a href="{{ $data['longestPost']['href'] }}">{{ $data['longestPost']['title'] }}</a>
                {{ $data['longestPost']['length'] }} символов
            </li>
            <li>Самая короткая статья:
                <a href="{{ $data['shortestPost']['href'] }}">{{ $data['shortestPost']['title'] }}</a>
                {{ $data['shortestPost']['length'] }} символов
            </li>
            <li>Средние количество статей у активных пользователей: {{ $data['posts']['averageNumberFromActiveAuthors'] }}</li>
            <li>Самая редактируемая статья:
                <a href="{{ $data['mostChangedPost']['href'] }}">{{ $data['mostChangedPost']['title'] }}</a>
                {{ $data['mostChangedPost']['times'] }} раз
            </li>
            <li>Самая комментируемая статья:
                <a href="{{ $data['mostCommentedPost']['href'] }}">{{ $data['mostCommentedPost']['title'] }}</a>
                {{ $data['mostCommentedPost']['times'] }} комментариев
            </li>
        </ul>
    @endif
@endsection
