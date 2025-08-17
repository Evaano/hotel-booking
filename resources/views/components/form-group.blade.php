@props([
    "label",
    "name",
    "required" => false,
])

<div class="form-group">
    @if ($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if ($required)
                <span class="text-error-500 ml-1">*</span>
            @endif
        </label>
    @endif

    {{ $slot }}
</div>
