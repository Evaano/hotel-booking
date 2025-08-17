@props(["variant" => "info", "dismissible" => false])

@php
    $variantClasses = match ($variant) {
        "success" => "alert-success",
        "warning" => "alert-warning",
        "error" => "alert-error",
        default => "alert-info",
    };
@endphp

<div {{ $attributes->merge(["class" => "alert {$variantClasses}"]) }}>
    <div class="flex items-start justify-between">
        <div class="flex-1">
            {{ $slot }}
        </div>

        @if ($dismissible)
            <button
                type="button"
                class="ml-4 text-muted-400 hover:text-muted-600 transition-colors duration-200"
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"
                    ></path>
                </svg>
            </button>
        @endif
    </div>
</div>
