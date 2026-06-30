@props([
    'label' => null,
    'for' => null,
    'required' => false,
    'error' => null,            // explicit message; otherwise pulled from $errors by `name`
    'name' => null,             // field name used to look up validation errors
    'hint' => null,
])

@php
    $message = $error;
    if (!$message && $name && $errors->has($name)) {
        $message = $errors->first($name);
    }
@endphp

<div {{ $attributes->class(['field']) }}>
    @if($label)
        <label class="field-label" @if($for) for="{{ $for }}" @endif>
            {{ $label }}@if($required)<span class="field-req">*</span>@endif
        </label>
    @endif

    {{ $slot }}

    @if($message)
        <div class="field-error">{{ $message }}</div>
    @elseif($hint)
        <div class="field-hint">{{ $hint }}</div>
    @endif
</div>
