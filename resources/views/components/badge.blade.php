@props(["variant" => "primary"])

@php
    $variantClasses = match ($variant) {
        "success" => "badge-success",
        "warning" => "badge-warning",
        "error" => "badge-error",
        "muted" => "badge-muted",
        default => "badge-primary",
    };
@endphp

<span {{ $attributes->merge(["class" => "badge {$variantClasses}"]) }}>
    {{ $slot }}
</span>
