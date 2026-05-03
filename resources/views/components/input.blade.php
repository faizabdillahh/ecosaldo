@props([
    'label' => null,
    'name' => '',
    'type' => 'text',
    'value' => null,
    'required' => false,
    'placeholder' => '',
])

<div>
    @if($label)
        <label for="{{ $name }}" class="text-xs font-medium text-gray-500 block mb-1">
            {{ $label }} @if($required)<span class="text-red-500" aria-hidden="true">*</span><span class="sr-only">(wajib)</span>@endif
        </label>
    @endif
    <input 
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        aria-required="{{ $required ? 'true' : 'false' }}"
        {{ $attributes->merge(['class' => 'w-full text-sm border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-eco focus:border-eco transition']) }}
    >
</div>