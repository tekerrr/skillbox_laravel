@extends('app')

@section('title', 'Page Demo Title')

@section('content')
    Содержимое страницы Demo
@endsection

@section('sidebar')
    @parent
    <p>Переопределенное demo содержимое боковой панели</p>

    {{ $data ?? 'html безопансый вывод данных' }}
    {!! $data ?? 'html НЕбезопансый вывод данных' !!}
    {{-- Это комментарий blade --}}
    @{{ Просто выведется текст со скобками }}
    @verbatim
        {{ Просто выведется текст со скобками как выше }}
    @endverbatim

    <script>
        var app = <?=json_encode($data ?? '')?>
        var app = @json($data ?? '')
    </script>

    @if (1)
        //
    @elseif (2)
        //
    @else
        //
    @endif

    @unless(Auth::check())
        // пока пользователь авторизован
    @endunless

    @isset($data)
    @endisset

    @empty($data)
    @endempty

    @auth
        // auth
    @elseauth
        // not auth
    @endauth

    @guest
        // not auth
    @endguest

    @hasSection('sidebar')
        // в секции есть контент
    @endif

    @switch($item ?? '')
        @case (1)
            // first
            @break
        @case (2)
            // second
        @default (1)
            // default
    @endswitch

{{--    @for ($i = 0; $i < 10; $i++)--}}
{{--        {{ $i }}--}}
{{--    @endfor--}}

{{--    @while (false)--}}
{{--        // never--}}
{{--    @endwhile--}}

{{--    @foreach ($users as $user)--}}
{{--        //--}}
{{--    @endforeach--}}

    @forelse ($users as $user)

{{--        @if ($user->id == 1)--}}
{{--            @continue--}}
{{--        @endif--}}

{{--        @if ($user->id > 5)--}}
{{--            @break--}}
{{--        @endif--}}

        @if ($loop->first) {{-- $loop->parent->first --}}
            Это первый пользователь
        @endif

        @if ($loop->last)
            Это последний пользователь
        @endif

        @continue($user->id == 1)
        @break($user->id > 5)

        <p>Пользователь: {{ $user->id }}</p>
    @empty
        <p>Нет ни одного пользователя</p>
    @endforelse


    @php
    @endphp

    <form>
        @csrf
        @method('PUT')
    </form>

    @inject('pushall', '\App\Service\PushAll')
    @dd($pushall)

    @env('local)
    @elseenv('testing')
    @else
    @endenv



@endsection
