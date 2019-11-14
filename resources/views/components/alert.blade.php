<div class="alert alert-{{ $type ?? 'danger' }} mt-4">
    @isset($title)
        <h4 class="alert-heading">{{ $title }}</h4>
    @endisset
    {{ $slot }}
</div>
