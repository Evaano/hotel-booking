@props(["header" => null, "footer" => null])

<div {{ $attributes->merge(["class" => "card hover-lift"]) }}>
    @if ($header)
        <div class="card-header">
            {{ $header }}
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @if ($footer)
        <div
            class="px-6 py-4 border-t border-muted-200/50 bg-muted-50/30 rounded-b-2xl"
        >
            {{ $footer }}
        </div>
    @endif
</div>
