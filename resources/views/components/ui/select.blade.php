{{--
    Reusable Select Component

    @param string $name - Select name
    @param string $label - Label text
    @param array $options - Options array [value => label]
    @param string $selected - Selected value
    @param string $placeholder - Placeholder option
    @param string $error - Error message
    @param bool $required - Required field
--}}

@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Pilih...',
    'error' => null,
    'required' => false,
])

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
            <option value="" disabled {{ !$selected ? 'selected' : '' }}>{{ $placeholder }}</option>
        @endif

        @foreach($options as $value => $optionLabel)
            <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
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
