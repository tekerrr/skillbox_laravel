@extends('layout.master_without_sidebar')

@section('title', 'Сохранённые отчёты')

@section('content')
    <ul>
        @forelse($files as $file)
            <li><a href="{{ route('admin.reports.files.download', compact('file')) }}">{{ $file }}</a></li>
        @empty
            <li>Отчёты отсутствуют</li>
        @endforelse
    </ul>
@endsection
