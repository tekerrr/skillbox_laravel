@extends('layout.master_without_sidebar')

@section('title', 'Список новостей')

@section('content')
    <div class="form-group">
        <a class="btn btn-outline-primary mb-3" href="{{ route('admin.news.create') }}">Создать</a>
    </div>

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
        @foreach($news as $oneNews)
            <tr>
                <th scope="row">{{ $oneNews->id }}</th>
                <td><a href="/news/{{ $oneNews->slug }}">{{ $oneNews->title }}</a></td>
                <td>{{ $oneNews->created_at->toformattedDateString() }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.news.' . ($oneNews->isActive() ? 'deactivate' : 'activate'), ['news' => $oneNews]) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-outline-{{ $oneNews->isActive() ? 'danger' : 'primary' }}">
                            {{ $oneNews->isActive() ? 'Деактивировать' : 'Активировать' }}
                        </button>
                    </form>
                </td>
                <td>
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.news.edit', ['news' => $oneNews]) }}">Изменить</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
