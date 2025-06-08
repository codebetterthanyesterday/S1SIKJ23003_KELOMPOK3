@php
    $isActive = url()->current() === url($attributes->get('href'));
@endphp
<a {{ $attributes->class([
    'bg-purple-100 text-purple-700 font-semibold shadow-inner' => $isActive,
]) }}
    aria-current="page">{{ $slot }}</a>
