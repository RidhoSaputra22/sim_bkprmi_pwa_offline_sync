{{--
    Reusable Input Component

    @param string $name - Input name
    @param string $label - Label text
    @param string $type - Input type (text, email, password, number, etc.)
    @param string $placeholder - Placeholder text
    @param string $value - Current value
    @param string $error - Error message
    @param bool $required - Required field
    @param string $helpText - Helper text below input
--}}

@props([
    'name',
    'label' => null,
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'error' => null,
    'required' => false,
    'helpText' => null,
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

    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => 'input input-bordered w-full' . ($error ? ' input-error' : '')]) }}
        {{ $required ? 'required' : '' }}
    />

    @if($helpText && !$error)
        <label class="label">
            <span class="label-text-alt text-base-content/70">{{ $helpText }}</span>
        </label>
    @endif

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
