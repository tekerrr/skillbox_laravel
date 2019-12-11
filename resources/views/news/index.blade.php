@extends('layout.master')

@section('title', 'Новости')

@section('content')
    @foreach($news as $oneNews)
        @include('news.item', ['news' => $oneNews])
    @endforeach

    {{ $news->links('pagination.view') }}
@endsection
