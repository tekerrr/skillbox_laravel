@extends('layout.master')

@section('title', 'Создание статью')

@section('content')

    <div class="col-md-8 blog-main">
        <h3 class="pb-3 mb-4 font-italic border-bottom">
            Создание статьи
        </h3>

        @include('layout.errors')

        <form method="post" action="/posts">

            @csrf

            <div class="form-group">
                <label for="inputSlug">Символьный код</label>
                <input type="text" class="form-control" id="inputSlug" placeholder="Введите символьный код" name="slug">
            </div>
            <div class="form-group">
                <label for="inputTitle">Название статьи</label>
                <input type="text" class="form-control" id="inputTitle" placeholder="Введите название статьи" name="title">
            </div>
            <div class="form-group">
                <label for="inputAbstract">Краткое описание статьи</label>
                <input type="text" class="form-control" id="inputAbstract" placeholder="Введите описание" name="abstract">
            </div>
            <div class="form-group">
                <label for="inputBody">Детальное описание стати</label>
                <input type="text" class="form-control" id="inputBody" placeholder="Введите описание" name="body">
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="checkboxPublished" value="1" name="published">
                <label class="form-check-label" for="checkboxPublished">Опубликовано</label>
            </div>
            <button type="submit" class="btn btn-primary">Создать статью</button>
        </form>
    </div>

@endsection
