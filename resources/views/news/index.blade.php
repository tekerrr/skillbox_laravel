@extends('layout.master')

@section('title', 'Новости')

@section('content')
    @foreach($news as $oneNews)
        @include('news.item', ['news' => $oneNews])
    @endforeach
@endsection
