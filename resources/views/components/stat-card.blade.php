@props([
    'label' => '',
    'value' => '',
    'hint' => null,
    'valueClass' => 'text-gray-900',
])

<div {{ $attributes->merge(['class' => 'card p-6']) }}>
    <div class="flex items-start justify-between">
        <div>
            <div class="text-sm text-gray-500">{{ $label }}</div>
            <div class="mt-2 text-2xl font-bold {{ $valueClass }}">{{ $value }}</div>
            @if ($hint)
                <div class="mt-1 text-xs text-gray-600">{{ $hint }}</div>
            @endif
        </div>
        @if (trim($slot))
            <div class="text-blue-600">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>


