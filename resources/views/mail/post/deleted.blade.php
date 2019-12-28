@component('mail::message')
# Удалена статья: {{ $post->title }}

{{ $post->abstract }}

С уважением,
{{ config('app.name') }}
@endcomponent
