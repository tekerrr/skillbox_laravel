@component('mail::message')
# Добавлена новая статья: {{ $post->title }}

{{ $post->abstract }}

@component('mail::button', ['url' => '/posts/' . $post->slug])
Прочитать статью
@endcomponent

С уважением,<br>
{{ config('app.name') }}
@endcomponent
