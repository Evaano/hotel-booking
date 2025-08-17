<button
    {{ $attributes->merge(["type" => "submit", "class" => "btn-error"]) }}
>
    {{ $slot }}
</button>
