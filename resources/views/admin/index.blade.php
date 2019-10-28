@extends('layout.master')

@section('title', 'Административный раздел')

@section('content')
    <div class="col-md-8 blog-main">
        <h3 class="pb-3 mb-4 font-italic border-bottom">
            Административный раздел
        </h3>
        <ul>
            <li><a href="/admin/feedback">Список обращений</a></li>
        </ul>
    </div>
@endsection
