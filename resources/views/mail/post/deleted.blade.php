@component('mail::message')
# Удалена статья: {{ $post->title }}

{{ $post->abstract }}

С уважением,<br>
{{ config('app.name') }}
@endcomponent
