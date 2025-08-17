@props([
    "active",
])

@php
    $classes =
        $active ?? false
            ? "nav-link-active whitespace-nowrap"
            : "nav-link whitespace-nowrap";
@endphp

<a
    {{ $attributes->merge(["class" => $classes]) }}
>
    {{ $slot }}
</a>
