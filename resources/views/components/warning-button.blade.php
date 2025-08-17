<button
    {{ $attributes->merge(["type" => "submit", "class" => "btn-warning"]) }}
>
    {{ $slot }}
</button>
