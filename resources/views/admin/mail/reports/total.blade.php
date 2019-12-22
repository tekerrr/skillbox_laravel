@component('mail::message')
    # Сгенерирован отчёт: Итого

    @foreach ($report as $key => $value)
        - {{ $key }}: {{ $value }}
    @endforeach

    Приложенный файл: {{ $csvName }}

    С уважением,
    {{ config('app.name') }}
@endcomponent
