@component('mail::message')
# Новые статьи на сайте за последние {{ $period }} дней

@foreach ($posts as $post)
- [{{ $post->title }}](/posts/{{ $post->slug }})
@endforeach

Thanks,<br>
{{ config('app.name') }}
@endcomponent
