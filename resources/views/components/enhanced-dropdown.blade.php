@props([
    "id" => null,
    "align" => "right",
    "width" => "48",
    "trigger" => null,
    "content" => null,
])

@php
    $alignmentClasses = match ($align) {
        "left" => "ltr:origin-top-left rtl:origin-top-right start-0",
        "top" => "origin-top",
        default => "ltr:origin-top-right rtl:origin-top-left end-0",
    };

    $width = match ($width) {
        "32" => "w-32",
        "48" => "w-48",
        "56" => "w-56",
        "64" => "w-64",
        default => $width,
    };
@endphp

<div
    class="relative"
    x-data="{ open: false }"
    @click.outside="open = false"
    @close.stop="open = false"
    x-init="
        $watch('open', (value) => {
            const card = $el.closest('.card')
            if (card) {
                if (value) {
                    card.classList.add('relative', 'z-50')
                } else {
                    card.classList.remove('z-50')
                }
            }
        })
    "
>
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 {{ $width }} rounded-2xl shadow-large {{ $alignmentClasses }}"
        style="display: none"
        @click="open = false"
    >
        <div
            class="rounded-2xl ring-1 ring-muted-200/50 border border-white/20 bg-white/95 backdrop-blur-md py-2"
        >
            {{ $content }}
        </div>
    </div>
</div>
