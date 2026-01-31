{{--
    Reusable Select Component

    @param string $name - Select name
    @param string $label - Label text
    @param array $options - Options array: [value => label] OR [['value' => x, 'label' => y]]
    @param string $value - Selected value (use instead of selected)
    @param string $selected - Selected value (deprecated, use value)
    @param string $placeholder - Placeholder option
    @param string $error - Error message
    @param bool $required - Required field
--}}

@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'selected' => null,
    'placeholder' => 'Pilih...',
    'error' => null,
    'required' => false,
])

@php
    // Support both 'value' and 'selected' prop for backwards compatibility
    $selectedValue = $value ?? $selected;
@endphp

<div class="form-control w-full">
    @if($label)
        <label class="label" for="{{ $name }}">
            <span class="label-text">
                {{ $label }}
                @if($required)
                    <span class="text-error">*</span>
                @endif
            </span>
        </label>
    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'select select-bordered w-full' . ($error ? ' select-error' : '')]) }}
        {{ $required ? 'required' : '' }}
    >
        @if($placeholder)
            <option value="" disabled {{ !old($name, $selectedValue) ? 'selected' : '' }}>{{ $placeholder }}</option>
        @endif

        @foreach($options as $key => $option)
            @php
                // Support both formats: [value => label] and [['value' => x, 'label' => y]]
                if (is_array($option) && isset($option['value']) && isset($option['label'])) {
                    $optionValue = $option['value'];
                    $optionLabel = $option['label'];
                } else {
                    $optionValue = $key;
                    $optionLabel = $option;
                }
            @endphp
            <option value="{{ $optionValue }}" {{ old($name, $selectedValue) == $optionValue ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>

    @if($error)
        <label class="label">
            <span class="label-text-alt text-error">{{ $error }}</span>
        </label>
    @endif

    @error($name)
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
    @enderror
</div>
