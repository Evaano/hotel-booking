@props(["href" => null, "type" => "link"])

@if ($type === "button")
    <button
        {{ $attributes->merge(["class" => "dropdown-item w-full text-left"]) }}
    >
        {{ $slot }}
    </button>
@else
    <a
        href="{{ $href }}"
        {{ $attributes->merge(["class" => "dropdown-item"]) }}
    >
        {{ $slot }}
    </a>
@endif
