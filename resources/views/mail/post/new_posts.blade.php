@component('mail::message')
# Новые статьи на сайте за последние {{ $period }} дней

@foreach ($posts as $post)
- [{{ $post->title }}](route('posts.show', compact('post')))
@endforeach

Thanks,<br>
{{ config('app.name') }}
@endcomponent
