@props(['status'])

@if ($status)
    <div {{ $attributes }}>
        {{ __($status) }}
    </div>
@endif
