@extends('layout.master_without_sidebar')

@section('title', 'Статистика портала')

@section('content')
    <ul>
        @foreach($statistics as $key => $value)
            <li>{{ $key }}: {!! $value !!}</li>
        @endforeach
    </ul>
@endsection
