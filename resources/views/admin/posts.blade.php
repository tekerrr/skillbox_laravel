@extends('layout.master_without_sidebar')

@section('title', 'Список статей')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Заголовок</th>
            <th scope="col">Дата создания</th>
            <th scope="col">Статус</th>
            <th scope="col">Дейсвтие</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <th scope="row">{{ $post->id }}</th>
                <td><a href="{{ route('posts.show', compact('post')) }}">{{ $post->title }}</a></td>
                <td>{{ $post->created_at->toformattedDateString() }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.posts.' . ($post->isActive() ? 'deactivate' : 'activate'), compact('post')) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-{{ $post->isActive() ? 'danger' : 'primary' }}">
                            {{ $post->isActive() ? 'Деактивировать' : 'Активировать' }}
                        </button>
                    </form>
                </td>
                <td>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('posts.edit', compact('post')) }}">Изменить</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
