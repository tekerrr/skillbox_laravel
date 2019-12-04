@component('mail::message')
# Добавлена новая статья: {{ $post->title }}

{{ $post->abstract }}

@component('mail::button', ['url' => route('posts.show', compact('post'))])
Прочитать статью
@endcomponent

С уважением,<br>
{{ config('app.name') }}
@endcomponent
