@extends('layout.master_without_sidebar')

@section('title', 'Список обращений')

@section('content')
    <table class="table">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">title</th>
            <th scope="col">Дата создания</th>
            <th scope="col">Статус</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <th scope="row">{{ $post->id }}</th>
                <td>{{ $post->title }}</td>
                <td>{{ $post->created_at->toformattedDateString() }}</td>
                <td>
                    <form method="POST" action="">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-{{ $post->published ? 'danger' : 'primary' }}">
                            {{ $post->published ? 'Деактивировать' : 'Активировать' }}
                        </button>
                    </form>
                </td>
                <td>
                    <a class="btn btn-sm btn-primary" href="#">Изменить</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
